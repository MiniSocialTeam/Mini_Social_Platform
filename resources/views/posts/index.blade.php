@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Formulaire -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="content" class="form-control" placeholder="Quoi de neuf ?" required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Publier</button>
                </form>
            </div>
        </div>

        <!-- Feed -->
        @foreach($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">
                        {{ $post->user->first_name }} {{ $post->user->last_name }}
                    </h6>
                    <p class="card-text">{{ $post->content }}</p>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    <div class="card-footer bg-white border-top-0">
                    <form action="{{ url('posts/'.$post->post_id.'/like') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ $post->isLikedBy(auth()->id() ?? 1) ? 'btn-danger' : 'btn-outline-danger' }} btn-sm">
                            ❤️ {{ $post->likes->count() }} Likes
                        </button>
                    </form>
</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection