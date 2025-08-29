<?php

namespace App\Services;

use App\Models\Knowledge;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Send ingest request to external service via HTTP POST.
     *
     * @param string $filePath
     * @return array|null
     * @throws \Exception
     */
    public function sendIngestRequest(string $filePath): ?array
    {
        $url = config('services.flask_ai.api_url') . '/ingest';
        $payload = [
            'tenant_id' => tenant('id'),
            'file_path' => $filePath,
        ];
        Log::info("Sending ingest request to {$url} with payload: " . json_encode($payload));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        if ($response->failed()) {
            throw new \Exception("Ingest request failed: " . $response->body());
        }

        return $response->json();
    }

    public function ingestFile(Media $media, int $knowledgeId)
    {
        $content = '';

        if ($media->mime_type === config('common.knowledge.mime_types.txt')) {
            $content = Storage::disk('r2')->get($media->getPath());
        }
        // TODO: PDF/DOCX parser ở đây

        if (!$content) {
            Log::warning("No text extracted from {$media->getPath()}");
            return;
        }

        // 1. Chia nhỏ văn bản thành các đoạn (chunks)
        $chunkSize = 500; // Kích thước mỗi đoạn
        $chunks = str_split($content, $chunkSize);
        // Gọi OpenAI embedding API
        $apiKey = config('services.openai.api_key');
        $client = OpenAI::client($apiKey);
        $qdrantUrl = config('services.qdrant.api_url');

        foreach ($chunks as $chunk) {
            $embeddingResponse = $client->embeddings()->create([
                'model' => 'text-embedding-3-small',
                'input' => $chunk,
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
            $collectionName = "knowledge_" . tenant('id');
            $response = Http::withHeaders([
                'api-key' => config('services.qdrant.api_key'),
            ])->put("$qdrantUrl/collections/$collectionName/points", $payload);

            if ($response->failed()) {
                throw new \Exception("Qdrant ingest failed: " . $response->body());
            }
        }
    }

    public function search()
    {
        $apiKey = config('services.openai.api_key');
        $client = OpenAI::client($apiKey);
        $qdrantUrl = config('services.qdrant.api_url');

        $embeddingResponse = $client->embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => 'giới thiệu về dự án Paycreate',
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
        $collectionName = "knowledge_" . tenant('id');
        $response = Http::withHeaders([
            'api-key' => $apiKey,
        ])->post("$qdrantUrl/collections/$collectionName/points/search", $queryPayload);

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
        $collectionName = "knowledge_" . tenant('id');
        $response = Http::withHeaders([
            'api-key' => config('services.qdrant.api_key'),
        ])->put("$qdrantUrl/collections/$collectionName/points", $payload);

        if ($response->failed()) {
            throw new \Exception("Qdrant ingest failed: " . $response->body());
        }
    }
}
