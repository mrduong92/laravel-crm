<?php

namespace App\Listeners;

use App\Models\Knowledge;
use Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class MediaLogger
{
    public function handle(MediaHasBeenAddedEvent $event)
    {
        $media = $event->media;
        $path = $media->getPath();
        Log::info("file {$path} has been saved for media {$media->id}");
        // Save to Knowledges table
        $knowledge = new Knowledge();
        $knowledge->title = $media->name;
        $knowledge->content = $media->name;
        $knowledge->type = 'file';
        $knowledge->media_id = $media->id;
        $knowledge->save();
    }
}
