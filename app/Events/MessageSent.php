<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $senderId;
    public $receiverId;
    public $text;
    public $createdAt;

    public function __construct(Message $message)
    {
        $this->senderId = $message->sender_id;
        $this->receiverId = $message->receiver_id;
        $this->text = $message->message;
        $this->createdAt = $message->created_at?->toDateTimeString();
    }

    public function broadcastOn()
    {
        $users = [$this->senderId, $this->receiverId];
        sort($users);
        return [new PrivateChannel('chat.' . implode('_', $users))];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    // ✅ Send FLAT data so JS can access event.message directly
    public function broadcastWith(): array
    {
        return [
            'sender_id' => $this->senderId,
            'message' => $this->text,
            'created_at' => $this->createdAt,
        ];
    }
}