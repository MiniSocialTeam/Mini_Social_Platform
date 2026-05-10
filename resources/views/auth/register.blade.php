@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4">Inscription</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="first_name" class="form-label">Prénom</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Nom</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Créer un compte</button>
                </form>

                <p class="mt-3 mb-0">Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
