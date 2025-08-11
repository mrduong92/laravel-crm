<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Namu\WireChat\Events\MessageCreated;
use Namu\WireChat\Models\Message;
use Namu\WireChat\Models\Conversation;

class SendZaloMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageCreated $event): void
    {
        $data = $event->message->toArray();
        \Log::info('SendZaloMessage', [
            'message_id' => $data['id'],
            'conversation_id' => $data['conversation_id'],
        ]);
        $message = Message::find($data['id']);
        $conversation = Conversation::find($data['conversation_id']);
        if (!$conversation) {
            return; // Conversation not found, exit early
        }
        // Call Zalo API to send the message
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://5d36deaed552.ngrok-free.app/send-message', [
            'content' => $message['body'] ?? 'Nội dung tin nhắn',
            'threadId' => $conversation->thread_id,
            'threadType' => 0,
        ]);

        // Handle the response
        if ($response->successful()) {
            \Log::info('Zalo message sent successfully', [
                'message_id' => $data['id'],
                'conversation_id' => $data['conversation_id'],
                'response' => $response->json(),
            ]);
        } else {
            \Log::error('Failed to send Zalo message', [
                'message_id' => $data['id'],
                'conversation_id' => $data['conversation_id'],
                'response' => $response->body(),
            ]);
        }
    }
}
