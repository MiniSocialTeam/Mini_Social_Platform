@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        <!-- Section d'ajout de Story -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Nouvelle Story</h5>
                <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <button class="btn btn-primary" type="submit">Publier</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Affichage des Stories (Le "Barre" de stories) -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Stories actives</h5>
                <div class="story-container">
                    @forelse($stories as $story)
                        <div class="text-center" style="min-width: 80px;">
                            <a href="{{ route('stories.show', $story->id_story) }}">
                                <img src="{{ asset('storage/' . $story->image) }}" class="story-circle">
                            </a>
                            <div class="small mt-1 text-truncate">{{ $story->user->first_name }}</div>
                        </div>
                    @empty
                        <p class="text-muted">Aucune story pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection