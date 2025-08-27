<?php

namespace App\Listeners;

use Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class MediaLogger
{
    public function handle(MediaHasBeenAddedEvent $event)
    {
        $media = $event->media;
        $path = $media->getPath();
        Log::info("file {$path} has been saved for media {$media->id}");
    }
}
