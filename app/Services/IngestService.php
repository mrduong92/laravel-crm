<?php

namespace App\Services;

use App\Models\Knowledge;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OpenAI;

class IngestService
{
    public function ingestKnowledgeChunksToQdrant(Knowledge $knowledge)
    {
        $text = $knowledge->title . "\n" . $knowledge->content;
        // 1. Chia nhỏ văn bản thành các đoạn (chunks)
        $chunkSize = 500; // Kích thước mỗi đoạn
        $chunks = str_split($text, $chunkSize);

        foreach ($chunks as $chunk) {
            $this->ingestChunkToQdrant($knowledge->title, $chunk);
        }
    }

    public function search()
    {
        $apiKey = config('app.openai.api_key');
        $client = OpenAI::client($apiKey);
        $qdrantUrl = config('app.qdrant.api_url');

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
        ])->post("$qdrantUrl/collections/knowledge/points/search", $queryPayload);

        return $response->json();
    }

    private function ingestChunkToQdrant(string $title, string $content)
    {
        $apiKey = config('app.openai.api_key');
        $client = OpenAI::client($apiKey);
        $qdrantUrl = config('app.qdrant.api_url');

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
            'api-key' => config('app.qdrant.api_key'),
        ])->put("$qdrantUrl/collections/knowledge/points", $payload);

        if ($response->failed()) {
            throw new \Exception("Qdrant ingest failed: " . $response->body());
        }
    }
}
