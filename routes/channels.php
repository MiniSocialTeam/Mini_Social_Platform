<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->user_id === (int) $id;
});

// ✅ Private chat channel: chat.{user1}_{user2}
Broadcast::channel('chat.{userId1}_{userId2}', function ($user, $userId1, $userId2) {
    $currentUserId = (int) $user->user_id;
    return $currentUserId === (int) $userId1 || $currentUserId === (int) $userId2;
});