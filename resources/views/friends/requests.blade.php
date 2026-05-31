@extends('layouts.app')
@section('content')

<style>
    .friends-page {
        max-width: 680px;
        margin: 0 auto;
        padding: 2.5rem 1rem 4rem;
        position: relative;
        z-index: 1;
    }

    .page-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -.5px;
        color: var(--text2);
        margin-bottom: 2rem;
    }

    /* ── SEARCH BOX ── */
    .search-form {
        display: flex;
        gap: .6rem;
        margin-bottom: 1rem;
    }
    .search-wrap {
        flex: 1;
        position: relative;
    }
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
        display: flex;
    }
    .search-input {
        width: 100%;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        padding: .75rem 1rem .75rem 2.75rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-input::placeholder { color: var(--muted); }
    .search-input:focus {
        border-color: rgba(108,99,255,.45);
        box-shadow: 0 0 0 3px rgba(108,99,255,.08);
    }
    .search-btn {
        background: linear-gradient(135deg, var(--accent), #8b5cf6);
        border: none;
        border-radius: 12px;
        color: #fff;
        padding: .75rem 1.3rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .85rem;
        cursor: pointer;
        transition: opacity .2s;
        white-space: nowrap;
    }
    .search-btn:hover { opacity: .88; }

    /* ── USER CARD ── */
    .user-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1rem 1.3rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: .75rem;
        transition: border-color .25s;
        animation: fade-up .3s both;
    }
    .user-card:hover { border-color: rgba(108,99,255,.2); }

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .u-avatar {
        width: 46px; height: 46px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1rem;
        color: #fff;
        flex-shrink: 0;
    }
    .u-info { flex: 1; }
    .u-name {
        font-weight: 600;
        font-size: .93rem;
        color: var(--text2);
        margin-bottom: .1rem;
    }
    .u-email { font-size: .76rem; color: var(--muted); }

    /* Status badges & buttons */
    .badge-connected {
        display: inline-flex; align-items: center; gap: .35rem;
        background: rgba(34,197,94,.1);
        border: 1px solid rgba(34,197,94,.25);
        border-radius: 999px;
        color: #4ade80;
        font-size: .78rem;
        font-weight: 500;
        padding: .35rem .85rem;
    }
    .badge-pending {
        display: inline-flex; align-items: center; gap: .35rem;
        background: rgba(245,158,11,.08);
        border: 1px solid rgba(245,158,11,.2);
        border-radius: 999px;
        color: #fbbf24;
        font-size: .78rem;
        font-weight: 500;
        padding: .35rem .85rem;
    }
    .btn-connect {
        display: inline-flex; align-items: center; gap: .4rem;
        background: linear-gradient(135deg, var(--accent), #8b5cf6);
        border: none;
        border-radius: 999px;
        color: #fff;
        font-size: .8rem;
        font-weight: 600;
        padding: .4rem 1rem;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        box-shadow: 0 2px 10px rgba(108,99,255,.25);
    }
    .btn-connect:hover { opacity: .88; transform: translateY(-1px); }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 999px;
        color: var(--muted);
        font-size: .8rem;
        font-weight: 500;
        padding: .4rem 1rem;
        cursor: pointer;
        transition: border-color .2s, color .2s;
    }
    .btn-cancel:hover { border-color: rgba(233,69,96,.35); color: var(--accent2); }

    /* ── SECTION LABEL ── */
    .section-label {
        font-family: 'Syne', sans-serif;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin: 1.75rem 0 .85rem;
        display: flex;
        align-items: center;
        gap: .7rem;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── ACCEPT / DECLINE ── */
    .btn-accept {
        display: inline-flex; align-items: center; gap: .4rem;
        background: rgba(34,197,94,.12);
        border: 1px solid rgba(34,197,94,.3);
        border-radius: 999px;
        color: #4ade80;
        font-size: .8rem;
        font-weight: 600;
        padding: .4rem 1rem;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-accept:hover { background: rgba(34,197,94,.2); }
    .btn-decline {
        display: inline-flex; align-items: center;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 999px;
        color: var(--muted);
        font-size: .8rem;
        padding: .4rem 1rem;
        cursor: pointer;
        transition: border-color .2s, color .2s;
    }
    .btn-decline:hover { border-color: rgba(233,69,96,.3); color: var(--accent2); }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--muted);
        font-size: .87rem;
    }

    .results-count {
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    .results-count span { color: var(--accent); font-weight: 600; }
</style>

<div class="friends-page">

    <div class="page-title">/ Connexions</div>

    {{-- ── RECHERCHE ── --}}
    <form action="{{ route('friends.requests') }}" method="GET" class="search-form">
        <div class="search-wrap">
            <span class="search-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </span>
            <input type="text" name="q" value="{{ request('q') }}"
                   class="search-input"
                   placeholder="Rechercher un utilisateur par nom ou email…"
                   autocomplete="off">
        </div>
        <button type="submit" class="search-btn">Rechercher</button>
    </form>

    {{-- ── RÉSULTATS RECHERCHE ── --}}
    @if(request('q'))
        <div class="results-count">
            <span>{{ $searchResults->count() }}</span>
            résultat{{ $searchResults->count() > 1 ? 's' : '' }} pour "{{ request('q') }}"
        </div>

        @forelse($searchResults as $u)
        <div class="user-card">
            <div class="u-avatar">{{ strtoupper(substr($u->first_name, 0, 1)) }}</div>
            <div class="u-info">
                <div class="u-name">{{ $u->first_name }} {{ $u->last_name }}</div>
                <div class="u-email">{{ $u->email }}</div>
            </div>
            <div>
                @if(auth()->user()->isFriendWith($u->user_id))
                    <span class="badge-connected">✓ Connecté</span>

                @elseif(auth()->user()->sentRequests->where('receiver_id', $u->user_id)->where('status','pending')->first())
                    {{-- Annuler la demande envoyée --}}
                    @php $req = auth()->user()->sentRequests->where('receiver_id', $u->user_id)->where('status','pending')->first() @endphp
                    <form action="{{ route('friends.cancel', $req->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-cancel">✕ Annuler</button>
                    </form>

                @elseif(auth()->user()->receivedRequests->where('sender_id', $u->user_id)->where('status','pending')->first())
                    {{-- Accepter / Refuser la demande reçue --}}
                    @php $req = auth()->user()->receivedRequests->where('sender_id', $u->user_id)->where('status','pending')->first() @endphp
                    <div style="display:flex; gap:.5rem;">
                        <form action="{{ route('friends.accept', $req->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-accept">✓ Accepter</button>
                        </form>
                        <form action="{{ route('friends.decline', $req->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-decline">Refuser</button>
                        </form>
                    </div>

                @else
                    <form action="{{ route('friends.send', $u->user_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-connect">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Connecter
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
            <div class="empty-state">Aucun utilisateur trouvé pour "{{ request('q') }}".</div>
        @endforelse
    @endif

    {{-- ── DEMANDES REÇUES ── --}}
    <div class="section-label">
        Demandes reçues
        @if($requests->count())
            <span style="background:var(--accent2);color:#fff;border-radius:999px;padding:.1rem .55rem;font-size:.7rem;font-family:'Syne',sans-serif;">
                {{ $requests->count() }}
            </span>
        @endif
    </div>

    @forelse($requests as $req)
    <div class="user-card">
        <div class="u-avatar">{{ strtoupper(substr($req->sender->first_name, 0, 1)) }}</div>
        <div class="u-info">
            <div class="u-name">{{ $req->sender->first_name }} {{ $req->sender->last_name }}</div>
            <div class="u-email">{{ $req->created_at->diffForHumans() }}</div>
        </div>
        <div style="display:flex; gap:.5rem;">
            <form action="{{ route('friends.accept', $req->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-accept">✓ Accepter</button>
            </form>
            <form action="{{ route('friends.decline', $req->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-decline">Refuser</button>
            </form>
        </div>
    </div>
    @empty
        <div class="empty-state">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                 style="opacity:.3; margin-bottom:.6rem; display:block; margin-inline:auto">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/>
            </svg>
            Aucune demande en attente.
        </div>
    @endforelse

</div>
@endsection