<?php

namespace App\Observers;

use Namu\WireChat\Events\MessageCreated;
use Illuminate\Support\Facades\Http;
use Namu\WireChat\Models\Message;
use Namu\WireChat\Models\Conversation;
use Log;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        $conversation = $message->conversation;
        Log::info('SendZaloMessage', [
            'message_id' => $message->id,
            'conversation_id' => $conversation->id,
        ]);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config('services.zalo.api_url') . '/send-message', [
            'messageId' => $message->id,
            'senderId' => $message['sendable_id'],
            'content' => $message['body'] ?? 'Nội dung tin nhắn',
            'threadId' => $conversation->thread_id,
            'threadType' => 0,
        ]);

        if ($response->successful()) {
            Log::info('Zalo message sent successfully', [
                'message_id' => $message->id,
                'conversation_id' => $conversation->id,
                'response' => $response->json(),
            ]);
        } else {
            Log::error('Failed to send Zalo message', [
                'message_id' => $message->id,
                'conversation_id' => $conversation->id,
                'response' => $response->body(),
            ]);
        }
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
