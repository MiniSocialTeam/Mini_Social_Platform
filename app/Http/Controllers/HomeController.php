<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Story;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Récupérer les stories actives (non expirées)
        // $stories = Story::where('expires_at', '>', now())
                        // ->with('user')
                        // ->latest()
                        // ->get();
                        $stories = collect();

        // 2. Récupérer les posts avec leurs auteurs et leurs likes
        $posts = Post::with(['user', 'likes'])
                     ->latest()
                     ->get();

        return view('home', compact('stories', 'posts'));
    }
}