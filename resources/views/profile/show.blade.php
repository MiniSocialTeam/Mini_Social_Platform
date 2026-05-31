@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    :root {
        --bg:        #0d0f14;
        --surface:   #13161e;
        --surface2:  #1a1e2a;
        --border:    rgba(255,255,255,0.07);
        --accent:    #6c63ff;
        --accent2:   #e94560;
        --slate:     #455d7a;   /* utilisé pour badges / tags */
        --text:      #f0f1f5;
        --text2:     #f5f6fa;
        --muted:     #6b7280;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    /* Noise + orbs */
    body::before {
        content: '';
        position: fixed; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none; z-index: 0; opacity: .5;
    }
    body::after {
        content: '';
        position: fixed; inset: 0;
        background:
            radial-gradient(ellipse 50% 40% at 20% 0%, rgba(108,99,255,0.1) 0%, transparent 70%),
            radial-gradient(ellipse 40% 40% at 80% 100%, rgba(69,93,122,0.12) 0%, transparent 70%);
        pointer-events: none; z-index: 0;
    }

    /* ── PAGE WRAPPER ── */
    .profile-page {
        position: relative; z-index: 1;
        max-width: 860px;
        margin: 0 auto;
        padding: 2.5rem 1rem 4rem;
    }

    /* ── COVER BANNER ── */
    .cover-banner {
        height: 200px;
        border-radius: 20px 20px 0 0;
        background: linear-gradient(135deg, #1a1340 0%, #0d1a2e 40%, #1a0d1f 100%);
        position: relative;
        overflow: hidden;
    }
    .cover-banner::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 30% 50%, rgba(108,99,255,0.25) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 75% 30%, rgba(233,69,96,0.15) 0%, transparent 60%);
    }
    /* Geometric lines décoration */
    .cover-banner::after {
        content: '';
        position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(
                -45deg,
                rgba(255,255,255,0.015) 0px,
                rgba(255,255,255,0.015) 1px,
                transparent 1px,
                transparent 28px
            );
    }

    /* ── PROFILE CARD ── */
    .profile-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-top: none;
        border-radius: 0 0 20px 20px;
        padding: 0 2rem 2rem;
        margin-bottom: 1.25rem;
        animation: fade-up .4s both;
    }
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Avatar */
    .avatar-wrap {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-top: -52px;
        margin-bottom: 1.25rem;
    }
    .avatar-ring {
        width: 108px; height: 108px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        padding: 3px;
        flex-shrink: 0;
    }
    .avatar-inner {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: var(--surface);
        overflow: hidden;
        border: 3px solid var(--surface);
    }
    .avatar-inner img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }
    /* Fallback initials avatar */
    .avatar-initials {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        color: #fff;
    }

    /* Edit button */
    .edit-btn {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text);
        padding: .55rem 1.1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        font-weight: 500;
        text-decoration: none;
        transition: border-color .2s, background .2s, transform .15s;
        margin-bottom: .25rem;
    }
    .edit-btn:hover {
        border-color: rgba(108,99,255,.4);
        background: rgba(108,99,255,.08);
        color: var(--text2);
        transform: translateY(-1px);
    }
    .edit-btn svg { color: var(--accent); }

    /* Name + meta */
    .profile-name {
        font-family: 'Syne', sans-serif;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.6px;
        color: var(--text2);
        margin-bottom: .2rem;
    }
    .profile-email {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .83rem;
        color: var(--muted);
        margin-bottom: .85rem;
    }

    /* Badge row */
    .badge-row {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        margin-bottom: 1.25rem;
    }
    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: rgba(69,93,122,0.18);
        border: 1px solid rgba(69,93,122,0.35);
        border-radius: 999px;
        padding: .3rem .85rem;
        font-size: .76rem;
        font-weight: 500;
        color: #7fa8cc;
        letter-spacing: .2px;
    }

    /* Divider */
    .divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 1.25rem 0;
    }

    /* Bio section */
    .section-label {
        font-family: 'Syne', sans-serif;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: .65rem;
    }
    .bio-text {
        font-size: .93rem;
        color: #9ca3af;
        line-height: 1.75;
    }
    .bio-empty {
        font-size: .88rem;
        color: var(--muted);
        font-style: italic;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── STATS ROW ── */
    .stats-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        animation: fade-up .4s .08s both;
    }
    .stat-col {
        text-align: center;
        padding: .75rem .5rem;
        position: relative;
    }
    .stat-col:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0; top: 20%; bottom: 20%;
        width: 1px;
        background: var(--border);
    }
    .stat-num {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        display: inline-block;
        background: linear-gradient(135deg, var(--text2), var(--accent));
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        margin-bottom: .15rem;
    }
    .stat-label {
        font-size: .75rem;
        color: var(--muted);
        letter-spacing: .3px;
    }

    /* ── RECENT POSTS ── */
    .section-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        animation: fade-up .4s .16s both;
    }
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .see-all {
        font-size: .78rem;
        color: var(--accent);
        text-decoration: none;
        transition: opacity .2s;
    }
    .see-all:hover { opacity: .75; }

    .mini-post {
        padding: .85rem 0;
        border-bottom: 1px solid var(--border);
    }
    .mini-post:last-child { border: none; padding-bottom: 0; }
    .mini-post-content {
        font-size: .87rem;
        color: #9ca3af;
        line-height: 1.6;
        margin-bottom: .45rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .mini-post-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: .75rem;
        color: var(--muted);
    }
    .mini-post-likes {
        display: flex;
        align-items: center;
        gap: .3rem;
        color: var(--accent2);
    }

    .no-posts {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--muted);
        font-size: .87rem;
    }
    .connect-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: linear-gradient(135deg, var(--accent), #8b5cf6);
    border: none;
    border-radius: 10px;
    color: #fff;
    padding: .55rem 1.1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity .2s, transform .15s;
    box-shadow: 0 2px 12px rgba(108,99,255,.3);
}
.connect-btn:hover { opacity: .88; transform: translateY(-1px); }

.connection-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    border-radius: 10px;
    padding: .55rem 1rem;
    font-size: .83rem;
    font-weight: 500;
}
.connection-badge.connected {
    background: rgba(34,197,94,.1);
    border: 1px solid rgba(34,197,94,.25);
    color: #4ade80;
}
.connection-badge.pending {
    background: rgba(245,158,11,.08);
    border: 1px solid rgba(245,158,11,.2);
    color: #fbbf24;
}

    /* ── MOBILE ── */
    @media (max-width: 600px) {
        .profile-card { padding: 0 1rem 1.5rem; }
        .profile-name { font-size: 1.3rem; }
        .cover-banner { height: 140px; }
        .stats-card { grid-template-columns: repeat(3,1fr); }
    }
</style>

<div class="profile-page">

    <!-- ── COVER + CARD ── -->
    <div class="cover-banner"></div>

    <div class="profile-card">
        <div class="avatar-wrap">
            {{-- N'afficher que si ce n'est pas le profil de l'utilisateur connecté --}}
@if(auth()->id() !== $user->user_id)
<div style="display:flex; gap:.6rem; margin-bottom:.25rem;">

    @if(auth()->user()->isFriendWith($user->user_id))
        {{-- Déjà amis --}}
        <span class="connection-badge connected">
            ✓ Connecté
        </span>

    @elseif(auth()->user()->hasPendingRequestWith($user->user_id))
        {{-- Demande en attente --}}
        <span class="connection-badge pending">
            ⏳ Demande en attente
        </span>

    @else
        {{-- Pas encore connectés --}}
        <form action="{{ route('friends.send', $user->user_id) }}" method="POST">
            @csrf
            <button type="submit" class="connect-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Se connecter
            </button>
        </form>
    @endif

</div>
@endif
            <div class="avatar-ring">
                <div class="avatar-inner">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="Avatar de {{ $user->first_name }}">
                    @else
                        <div class="avatar-initials">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="edit-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Modifier le profil
            </a>
        </div>

        <div class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</div>

        <div class="profile-email">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
            {{ $user->email }}
        </div>

        <div class="badge-row">
            <span class="badge-pill">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Membre depuis {{ $user->created_at->format('M Y') }}
            </span>
            <span class="badge-pill">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                Marrakech, Maroc
            </span>
        </div>

        <hr class="divider">

        <div class="section-label">Bio</div>
        @if($user->bio)
            <p class="bio-text">{{ $user->bio }}</p>
        @else
            <p class="bio-empty">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Aucune bio ajoutée —
                <a href="{{ route('profile.edit') }}" style="color:var(--accent);text-decoration:none;">en ajouter une</a>
            </p>
        @endif
    </div>

    <!-- ── STATS ── -->
    <div class="stats-card">
        <div class="stat-col">
            <div class="stat-num">{{ $user->posts->count() ?? 0 }}</div>
            <div class="stat-label">Posts</div>
        </div>
        <div class="stat-col">
            <div class="stat-num">{{ $user->posts->sum(fn($p) => $p->likes->count()) ?? 0 }}</div>
            <div class="stat-label">Likes reçus</div>
        </div>
        <div class="stat-col">
            <div class="stat-num">{{ $user->stories->count() ?? 0 }}</div>
            <div class="stat-label">Stories</div>
        </div>
    </div>

    <!-- ── RECENT POSTS ── -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-label" style="margin:0">Publications récentes</div>
            <a href="#" class="see-all">Voir tout →</a>
        </div>

        @if(isset($user->posts) && $user->posts->count())
            @foreach($user->posts->take(4) as $post)
            <div class="mini-post">
                <div class="mini-post-content">{{ $post->content }}</div>
                <div class="mini-post-meta">
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                    <span class="mini-post-likes">
                        ❤ {{ $post->likes->count() }}
                    </span>
                </div>
            </div>
            @endforeach
        @else
            <div class="no-posts">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="opacity:.3;margin-bottom:.6rem;display:block;margin-inline:auto">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Aucune publication pour le moment.
            </div>
        @endif
    </div>

</div>

@endsection