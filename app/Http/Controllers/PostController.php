<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::with('user')->latest()->get();
    return view('posts.index', compact('posts'));
}

public function store(Request $request)
{
    $request->validate(['content' => 'required|max:500']);

    Post::create([
        'content' => $request->content,
        'user_id' => auth()->id() ?? 1, // Ton hack de test pour Mohamed
    ]);

    return back()->with('success', 'Post publié !');
}
}
