<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        try {
            // ✅ Validate
            $validated = $request->validate([
                'receiver_id' => 'required|exists:users,user_id',
                'message'     => 'required|string|max:1000',
            ]);

            // ✅ Get current user safely
            $user = auth()->user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // ✅ Create message
            $message = Message::create([
                'sender_id'   => $user->user_id,
                'receiver_id' => $validated['receiver_id'],
                'message'     => $validated['message'],
            ]);

            // ✅ Broadcast (wrapped in try-catch so it won't break the response)
            try {
                broadcast(new MessageSent($message))->toOthers();
            } catch (\Exception $e) {
                Log::warning('Broadcast failed: ' . $e->getMessage());
                // Continue anyway — message is saved
            }

            return response()->json($message, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Message send failed: ' . $e->getMessage());
            // Return JSON error instead of HTML 500 page
            return response()->json([
                'error' => 'Server error',
                'message' => config('app.debug') ? $e->getMessage() : 'Something went wrong'
            ], 500);
        }
    }

    public function index(Request $request, $userId)
    {
        $myId = auth()->user()?->user_id;
        if (!$myId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $messages = Message::where(function($q) use ($userId, $myId) {
                $q->where('sender_id', $myId)->where('receiver_id', $userId);
            })
            ->orWhere(function($q) use ($userId, $myId) {
                $q->where('sender_id', $userId)->where('receiver_id', $myId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}