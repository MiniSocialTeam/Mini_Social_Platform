<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StoryController extends Controller
{
    // Affiche les stories actives (non expirées)
    public function index()
    {
        $stories = Story::where('expires_at', '>', now())
            ->with('user') // Eager loading pour éviter le problème N+1
            ->latest()
            ->get();

        return view('stories.index', compact('stories'));
    }

    // Enregistre une nouvelle story.
    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');

            Story::create([
                'image' => $path,
                'user_id' => auth()->id()??1, // Récupère l'ID de de l'utilisateur connecté
                'expires_at' => now()->addHours(24),
            ]);

            return redirect()->route('stories.index')->with('success', 'Story publiée !');
        }

        return back()->with('error', 'Erreur lors de l\'upload.');
    }
    /**
     * Affiche une story spécifique et enregistre la vue.
     */
    public function show(Story $story)
    {
        // Vérifier si la story est expirée
        if ($story->expires_at < now()) {
            abort(404, 'Cette story a expiré.');
        }
        // Enregistrer la vue si l'utilisateur ne l'a pas encore vue
        StoryView::firstOrCreate([
            'story_id' => $story->id_story,
            'user_id' => auth()->id(),
        ], [
            'viewed_at' => now()
        ]);

        return view('stories.show', compact('story'));
    }

}
