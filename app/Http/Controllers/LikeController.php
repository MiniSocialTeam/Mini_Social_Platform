<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle(Post $post)
{
    $userId = auth()->id() ?? 1; 

    $like = Like::where('post_id', $post->post_id)
                ->where('user_id', $userId)
                ->first();

    if ($like) {
        $like->delete(); // On enlève le like
    } else {
        Like::create([
            'post_id' => $post->post_id,
            'user_id' => $userId
        ]);
    }

    return back();
}
}
