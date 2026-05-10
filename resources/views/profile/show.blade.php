@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <img src="{{ $user->avatar_url }}" class="rounded-circle mb-3" width="120" height="120" alt="Avatar">
                <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-muted">{{ $user->email }}</p>

                <div class="mb-3">
                    <h5>Bio</h5>
                    <p>{{ $user->bio ?? 'Aucune bio ajoutée pour le moment.' }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier le profil</a>
            </div>
        </div>
    </div>
</div>
@endsection
