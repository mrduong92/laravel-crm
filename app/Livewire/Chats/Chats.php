<?php

namespace App\Livewire\Chats;

use Livewire\Component;
use Namu\WireChat\Models\Conversation;
use Namu\WireChat\Livewire\Chats\Chats as BaseChats;
use App\Models\User;
use Namu\WireChat\Facades\WireChat;

class Chats extends BaseChats
{
    /**
     * Loads conversations based on the current page and search filters.
     * Applies search filters and updates the conversations collection.
     *
     * @return void
     */
    protected function loadConversationsByUser(User $user): void
    {
        $perPage = 10;
        $offset = ($this->page - 1) * $perPage;

        // Determine conversations to fetch based on user role
        $role = $user->role; // assuming 'role' is a column on User model

        if ($role === 'owner') {
            // Owner: get conversations of admin and sales
            $adminIds = User::where('role', 'admin')->pluck('id');
            $salesIds = User::where('role', 'sales')->pluck('id');
            $userIds = $adminIds->merge($salesIds)->unique();
        } elseif ($role === 'admin') {
            // Admin: get conversations of sales of this admin
            $salesIds = User::where('role', 'sales')->where('created_by', $user->id)->pluck('id');
            $userIds = $salesIds;
        } elseif ($role === 'sales') {
            // Sales: get conversations of this sales only
            $userIds = collect([$user->id]);
        } else {
            // Default: only this user
            $userIds = collect([$user->id]);
        }

        $additionalConversations = Conversation::whereHas('participants', function ($query) use ($userIds) {
                $query->whereIn('participantable_id', $userIds);
            })
            ->with([
                'lastMessage.sendable',
                'group.cover' => fn($query) => $query->select('id', 'url', 'attachable_type', 'attachable_id', 'file_path'),
            ])
            ->when(trim($this->search ?? '') != '', fn($query) => $this->applySearchConditions($query))
            ->when(trim($this->search ?? '') == '', function ($query) {
                /** @phpstan-ignore-next-line */
                return $query->withoutDeleted()->withoutBlanks();
            })
            ->latest('updated_at')
            ->skip($offset)
            ->take($perPage)
            ->get();

        // Set participants manually where needed
        $additionalConversations->each(function ($conversation) {
            if ($conversation->isPrivate() || $conversation->isSelf()) {
                // Manually load participants (only 2 expected in private/self)
                $participants = $conversation->participants()->select('id', 'participantable_id', 'participantable_type', 'conversation_id', 'conversation_read_at')->with('participantable')->get();
                $conversation->setRelation('participants', $participants);

                // Set peer and auth participants
                $conversation->auth_participant = $conversation->participant($this->auth);
                $conversation->peer_participant = $conversation->peerParticipant($this->auth);
            }
        });

        $this->canLoadMore = $additionalConversations->count() === $perPage;

        $this->conversations = collect($this->conversations)
            ->concat($additionalConversations)
            ->unique('id')
            ->sortByDesc('updated_at')
            ->values();
    }

    /**
     * Loads conversations and renders the view.
     *
     * @return \Illuminate\View\View
     */
    // Add a public property to receive user_id from the URL
    public int $user_id;

    /**
     * Mounts the component and initializes conversations.
    *
    * @return void
    */
    public function mount(
        $showNewChatModalButton = null,
        $allowChatsSearch = null,
        $showHomeRouteButton = null,
        ?string $title = null,
        ) {
        // Get user_id from query string if present, otherwise use passed value or authenticated user
        $this->user_id = request()->query('user_id') ?? auth()->user()->id;
        // If a value is passed, use it; otherwise fallback to WireChat defaults.
        $this->showNewChatModalButton = isset($showNewChatModalButton) ? $showNewChatModalButton : WireChat::showNewChatModalButton();
        $this->allowChatsSearch = isset($allowChatsSearch) ? $allowChatsSearch : WireChat::allowChatsSearch();
        $this->showHomeRouteButton = isset($showHomeRouteButton) ? $showHomeRouteButton : ! $this->widget;
        $this->title = isset($title) ? $title : __('wirechat::chats.labels.heading');

        abort_unless(auth()->check(), 401);
        $this->selectedConversationId = request()->conversation;
        $this->conversations = collect();
    }

    public function render()
    {
        $user = User::find($this->user_id);
        if (!$user) {
            abort(404, 'User not found');
        }
        $this->loadConversationsByUser($user);

        return view('wirechat::livewire.chats.chats');
    }
}
