<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Namu\WireChat\Events\MessageCreated;
use Namu\WireChat\Models\Message;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/hook/message-created', function (Request $request) {
    \Log::info('Webhook received', $request->all());

    $messageId = $request->input('message_id');
    $message = Message::find($messageId);

    if (!$message) {
        return response()->json(['success' => false, 'error' => 'Message not found'], 404);
    }
    broadcast(new MessageCreated($message));
    return response()->json(['success' => true]);
});
