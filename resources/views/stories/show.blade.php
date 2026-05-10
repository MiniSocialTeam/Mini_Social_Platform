@extends('layouts.app')

@section('content')
<div class="container text-center">
    <div class="mb-3">
        <a href="{{ route('stories.index') }}" class="btn btn-secondary btn-sm">Retour</a>
    </div>

    <div class="story-viewer" style="display: inline-block; position: relative;">
        <img src="{{ asset('storage/' . $story->image) }}" 
             style="max-width: 400px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
        
        <div class="mt-2 text-muted">
            Publié par {{ $story->user->name }} {{ $story->user->name }} <br>
            <small>Expire le : {{ $story->expires_at }}</small>
        </div>
    </div>
</div>
@endsection