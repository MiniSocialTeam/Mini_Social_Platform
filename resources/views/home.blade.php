@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Colonne Principale -->
        <div class="col-md-8">
            
            <!-- SECTION STORIES -->
            <div class="card mb-4 shadow-sm border-0">

                <div class="card-body">
                    <div class="d-flex gap-3 overflow-auto pb-2">
                        @foreach($stories as $story)
                            <div class="text-center" style="min-width: 80px;">
                                <a href="{{ route('stories.show', $story->id_story) }}">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b6/Image_created_with_a_mobile_phone.png"
                                     style="width: 65px; height: 65px; border-radius: 50%; border: 3px solid #e1306c; padding: 2px; object-fit: cover;">
                                <div class="small text-truncate">{{ $story->user->first_name }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- SECTION CRÉER POST -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <textarea name="content" class="form-control border-0 bg-light" rows="3" placeholder="Quoi de neuf, Mohamed ?" required></textarea>
                        <hr>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">Publier</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FIL D'ACTUALITÉ -->
            @foreach($posts as $post)
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex align-items-center">
                        <div class="fw-bold">{{ $post->user->first_name }} {{ $post->user->last_name }}</div>
                        <small class="text-muted ms-2">• {{ $post->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <form action="{{ url('posts/'.$post->post_id.'/like') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ $post->isLikedBy(auth()->id() ?? 1) ? 'btn-danger' : 'btn-outline-secondary' }} btn-sm rounded-pill">
                                ❤️ {{ $post->likes->count() }} Likes
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- SIDEBAR (Le petit plus "Wildcard" pour le design) -->
        <div class="col-md-4 d-none d-lg-block">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="fw-bold">Suggestions pour vous</h6>
                    <p class="text-muted small"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection