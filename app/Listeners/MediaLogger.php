<?php

namespace App\Listeners;

use App\Models\Knowledge;
use App\Services\IngestService;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class MediaLogger
{
    protected $ingestService;

    public function __construct(IngestService $ingestService)
    {
        $this->ingestService = $ingestService;
    }

    public function handle(MediaHasBeenAddedEvent $event)
    {
        $media = $event->media;
        $path = $media->getPath();
        Log::info("file {$path} has been saved for media {$media->id}");
        // Save to Knowledge table
        $knowledge = new Knowledge();
        $knowledge->title = $media->name;
        $knowledge->content = $media->name;
        $knowledge->type = 'file';
        $knowledge->media_id = $media->id;
        $knowledge->save();

        // Gọi ingest sau khi save
        $response = $this->ingestService->sendIngestRequest($media->getPath());
        Log::info("Ingest response: " . json_encode($response));
    }
}
