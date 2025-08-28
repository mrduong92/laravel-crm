<?php

namespace App\Services;

use App\Models\Knowledge;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LivewireFilemanager\Filemanager\Models\Media;
use OpenAI;

class IngestService
{
    public function ingestText(Knowledge $knowledge)
    {
        $text = $knowledge->title . "\n" . $knowledge->content;
        // 1. Chia nhỏ văn bản thành các đoạn (chunks)
        $chunkSize = 500; // Kích thước mỗi đoạn
        $chunks = str_split($text, $chunkSize);

        foreach ($chunks as $chunk) {
            $this->ingestChunkToQdrant($knowledge->title, $chunk);
        }
    }

    public function ingestFile(Media $media, int $knowledgeId)
    {
        $content = '';

        if ($media->mime_type === config('common.knowledge.mime_types.txt')) {
            $content = file_get_contents($media->getPath());
        }
        // TODO: PDF/DOCX parser ở đây

        if (!$content) {
            Log::warning("No text extracted from {$media->getPath()}");
            return;
        }

        // Gọi OpenAI embedding API
        $apiKey = config('services.openai.api_key');
        $client = OpenAI::client($apiKey);
        $embeddingResponse = $client->embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => 'Chính sách đổi trả thế nào?',
        ]);
        $vector = $embeddingResponse['data'][0]['embedding'];
        $payload = [
            'points' => [
                [
                    'id' => $knowledgeId,
                    'vector' => $vector,
                    'payload' => [
                        'knowledge_id' => $knowledgeId,
                        'tenant_id'    => tenant('id'),
                        'title'        => $media->name,
                        'content'      => $content,
                        'source'       => $media->getPath(),
                    ],
                ],
            ],
        ];

        // Upsert vào Qdrant
        $qdrantUrl = config('services.qdrant.api_url');
        $response = Http::withHeaders([
            'api-key' => config('services.qdrant.api_key'),
        ])->post("$qdrantUrl/collections/knowledge_test/points", $payload);

        if ($response->failed()) {
            throw new \Exception("Qdrant ingest failed: " . $response->body());
        }
    }

    public function search()
    {
        $apiKey = config('services.openai.api_key');
        $client = OpenAI::client($apiKey);
        $qdrantUrl = config('services.qdrant.api_url');

        $embeddingResponse = $client->embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => 'Chính sách đổi trả thế nào?',
        ]);
        $vector = $embeddingResponse['data'][0]['embedding'];
        $queryPayload = [
            'vector' => $vector, // embedding của text query
            'top'    => 5,
            'with_payload' => true,
            'filter' => [
                'must' => [
                    [
                        'key' => 'tenant_id',
                        'match' => [
                            'value' => tenant('id'),
                        ]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'api-key' => $apiKey,
        ])->post("$qdrantUrl/collections/knowledge_test/points/search", $queryPayload);

        return $response->json();
    }

    private function ingestChunkToQdrant(string $title, string $content): void
    {
        $apiKey = config('services.openai.api_key');
        $client = OpenAI::client($apiKey);
        $qdrantUrl = config('services.qdrant.api_url');

        // 3. Gọi API embedding
        $embeddingResponse = $client->embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => $content,
        ]);

        $vector = $embeddingResponse['data'][0]['embedding'];

        // 4. Ingest vào Qdrant
        $payload = [
            'points' => [[
                'id' => Str::uuid(),
                'vector' => $vector,
                'payload' => [
                    'title'   => $title,
                    'content' => $content,
                    'tenant_id' => tenant('id'),
                ],
            ]],
        ];

        $response = Http::withHeaders([
            'api-key' => config('services.qdrant.api_key'),
        ])->put("$qdrantUrl/collections/knowledge/points", $payload);

        if ($response->failed()) {
            throw new \Exception("Qdrant ingest failed: " . $response->body());
        }
    }
}
