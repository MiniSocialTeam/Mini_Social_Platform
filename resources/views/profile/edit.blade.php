@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4">Modifier le profil</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="first_name" class="form-label">Prénom</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Nom</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea id="bio" name="bio" class="form-control" rows="4">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input id="avatar" type="file" name="avatar" class="form-control">
                        @if($user->avatar)
                            <div class="mt-2">
                                Avatar actuel : <img src="{{ $user->avatar_url }}" class="rounded-circle" width="50" height="50" alt="Avatar actuel">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
