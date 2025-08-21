<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Namu\WireChat\Models\Message;
use Namu\WireChat\Livewire\Chat\Chat as BaseChat;
use Namu\WireChat\Livewire\Chats\Chats;
use Livewire\Attributes\Computed;
use App\Models\User;

class Chat extends BaseChat
{
    // handle incomming broadcasted message event
    public function appendNewMessage($event)
    {

        // before appending message make sure it belong to this conversation
        if ($event['message']['conversation_id'] == $this->conversation->id) {

            // scroll to bottom
            $this->dispatch('scroll-bottom');

            $newMessage = Message::find($event['message']['id']);
            // dd($newMessage);

            // Make sure message does not belong to auth
            // if ($newMessage->sendable_id == auth()->id() && $newMessage->sendable_type == $this->auth->getMorphClass()) {
            //     return null;
            // }

            // push message
            $this->pushMessage($newMessage);

            // mark as read
            $this->conversation->markAsRead();

            // refresh chatlist
            // dispatch event 'refresh ' to chatlist
            $this->dispatch('refresh')->to(Chats::class);

            // broadcast
            // $this->selectedConversation->getReceiver()->notify(new MessageRead($this->selectedConversation->id));
        }
    }

    /**
     * Returns the authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    // #[Computed(persist: true)]
    // public function auth()
    // {
    //     return User::find(2);
    // }
}
