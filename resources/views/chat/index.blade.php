@extends('layouts.app')
@section('content')

<style>
    .chat-page {
        max-width: 680px;
        margin: 0 auto;
        padding: 2.5rem 1rem 4rem;
        position: relative; z-index: 1;
    }
    .page-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem; font-weight: 800;
        letter-spacing: -.5px; color: var(--text2);
        margin-bottom: 2rem;
    }
    .friend-card {
        display: flex; align-items: center; gap: 1rem;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1rem 1.3rem;
        margin-bottom: .75rem;
        text-decoration: none;
        transition: border-color .2s, transform .15s;
        animation: fade-up .3s both;
    }
    .friend-card:hover {
        border-color: rgba(108,99,255,.3);
        transform: translateX(4px);
    }
    @keyframes fade-up {
        from { opacity:0; transform:translateY(10px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .f-avatar {
        width: 46px; height: 46px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800; font-size: 1rem; color: #fff;
        flex-shrink: 0; position: relative;
    }
    .f-name { font-weight: 600; font-size: .93rem; color: var(--text2); }
    .f-sub  { font-size: .76rem; color: var(--muted); margin-top: .1rem; }
    .f-arrow { color: var(--muted); margin-left: auto; }
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        color: var(--muted); font-size: .87rem;
    }
</style>

<div class="chat-page">
    <div class="page-title">/ Messages</div>

    @forelse($friends as $friend)
    {{-- Lien vers la route existante de ton collègue --}}
    <a href="/chat/{{ $friend->user_id }}" class="friend-card">
        <div class="f-avatar">
            {{ strtoupper(substr($friend->first_name, 0, 1)) }}
        </div>
        <div>
            <div class="f-name">{{ $friend->first_name }} {{ $friend->last_name }}</div>
            <div class="f-sub">Cliquer pour discuter</div>
        </div>
        <div class="f-arrow">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </div>
    </a>
    @empty
    <div class="empty-state">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.2"
             style="opacity:.3;margin-bottom:.75rem;display:block;margin-inline:auto">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        Aucune connexion pour l'instant.<br>
        <a href="{{ route('friends.requests') }}"
           style="color:var(--accent);text-decoration:none;margin-top:.5rem;display:inline-block">
            Connecte-toi avec des utilisateurs →
        </a>
    </div>
    @endforelse
</div>

@endsection