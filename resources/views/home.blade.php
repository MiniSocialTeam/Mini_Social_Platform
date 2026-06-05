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
        --gold:      #f5c842;
        --text:     #455d7a;
        --muted:     #6b7280;
        --glow:      0 0 40px rgba(108,99,255,0.15);
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    /* ── BG NOISE TEXTURE ── */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: .5;
    }

    .feed-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1rem;
        position: relative;
        z-index: 1;
    }

    /* ── TOPBAR GREETING ── */
    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .topbar-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.6rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    display: inline-block;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    background-clip: text;

    color: transparent;
}
    .topbar-badge {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: .35rem 1rem;
        font-size: .78rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    .topbar-badge .dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px #22c55e;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%,100% { opacity:1; } 50% { opacity:.4; }
    }

    /* ── GLASS CARD ── */
    .g-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        backdrop-filter: blur(12px);
        margin-bottom: 1.25rem;
        overflow: hidden;
        transition: border-color .25s, box-shadow .25s;
    }
    .g-card:hover {
        border-color: rgba(108,99,255,.25);
        box-shadow: var(--glow);
    }

    /* ── STORY UPLOAD CARD ── */
    .story-upload {
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .story-upload label {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: .6rem;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: .55rem 1.1rem;
        font-size: .85rem;
        font-weight: 600;
        letter-spacing: .3px;
        transition: opacity .2s, transform .15s;
        white-space: nowrap;
    }
    .story-upload label:hover { opacity:.85; transform: translateY(-1px); }
    .story-upload input[type=file] { display: none; }
    .upload-hint {
        color: var(--muted);
        font-size: .8rem;
    }
    .upload-hint span { color: var(--text); font-weight: 500; }

    /* ── STORIES STRIP ── */
    .stories-strip {
        padding: 1.2rem 1.5rem;
    }
    .stories-strip-label {
        font-family: 'Syne', sans-serif;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    .stories-row {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: .5rem;
        scrollbar-width: none;
    }
    .stories-row::-webkit-scrollbar { display: none; }
    .story-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .4rem;
        min-width: 68px;
        text-decoration: none;
        cursor: pointer;
    }
    .story-ring {
        width: 62px; height: 62px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        padding: 2.5px;
        transition: transform .2s, filter .2s;
    }
    .story-ring:hover { transform: scale(1.08); filter: brightness(1.15); }
    .story-ring-inner {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: var(--surface2);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 2px solid var(--surface);
    }
    .story-ring-inner img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .story-name {
        font-size: .7rem;
        color: var(--muted);
        max-width: 64px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
    }

    /* ── COMPOSE BOX ── */
    .compose-box {
        padding: 1.25rem 1.5rem;
    }
    .compose-header {
        display: flex;
        align-items: center;
        gap: .85rem;
        margin-bottom: .85rem;
    }
    .avatar-sm {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .95rem;
        color: #fff;
        flex-shrink: 0;
    }
    .compose-placeholder {
        flex: 1;
    }
    .compose-textarea {
        width: 100%;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        padding: .85rem 1rem;
        resize: none;
        outline: none;
        transition: border-color .2s;
        min-height: 80px;
    }
    .compose-textarea::placeholder { color: var(--muted); }
    .compose-textarea:focus {
        border-color: rgba(108,99,255,.5);
        box-shadow: 0 0 0 3px rgba(108,99,255,.08);
    }
    .compose-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: .85rem;
    }
    .compose-actions {
        display: flex;
        gap: .5rem;
    }
    .compose-action-btn {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--muted);
        padding: .4rem .7rem;
        font-size: .8rem;
        cursor: pointer;
        transition: color .2s, border-color .2s;
    }
    .compose-action-btn:hover { color: var(--text); border-color: rgba(255,255,255,.15); }
    .publish-btn {
        background: linear-gradient(135deg, var(--accent), #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .55rem 1.4rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .85rem;
        letter-spacing: .3px;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
    }
    .publish-btn:hover { opacity: .88; transform: translateY(-1px); }

    /* ── POST CARD ── */
    .post-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        margin-bottom: 1.25rem;
        overflow: hidden;
        transition: border-color .25s, box-shadow .25s;
        animation: fade-up .4s both;
    }
    .post-card:nth-child(1) { animation-delay: .05s; }
    .post-card:nth-child(2) { animation-delay: .1s; }
    .post-card:nth-child(3) { animation-delay: .15s; }
    .post-card:nth-child(4) { animation-delay: .2s; }
    .post-card:hover {
        border-color: rgba(108,99,255,.2);
        box-shadow: 0 8px 32px rgba(0,0,0,.35);
    }

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .post-header {
        padding: 1.1rem 1.4rem .6rem;
        display: flex;
        align-items: center;
        gap: .85rem;
    }
    .avatar-post {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent2), var(--gold));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .95rem;
        color: #fff;
        flex-shrink: 0;
    }
    .post-meta { flex: 1; }
    .post-author {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .95rem;
        color: var(--text);
    }
    .post-time {
        font-size: .75rem;
        color: var(--muted);
        margin-top: .05rem;
    }
    .post-options {
        background: none;
        border: 1px solid var(--border);
        color: var(--muted);
        border-radius: 8px;
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 1rem;
        transition: border-color .2s, color .2s;
    }
    .post-options:hover { border-color: rgba(255,255,255,.15); color: var(--text); }

    .post-body {
        padding: .5rem 1.4rem 1rem;
        font-size: .93rem;
        line-height: 1.65;
        color: #c8cad4;
    }

    .post-footer {
        padding: .7rem 1.4rem 1rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        border-top: 1px solid var(--border);
    }

    /* Like button */
    .like-form { display: contents; }
    .like-btn {
        display: flex;
        align-items: center;
        gap: .45rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: .45rem 1rem;
        color: var(--muted);
        font-size: .82rem;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
    }
    .like-btn.liked {
        background: rgba(233,69,96,.12);
        border-color: rgba(233,69,96,.3);
        color: var(--accent2);
    }
    .like-btn:hover:not(.liked) {
        border-color: rgba(233,69,96,.3);
        color: var(--accent2);
    }
    .like-btn:hover { transform: scale(1.04); }

    .action-btn {
        display: flex;
        align-items: center;
        gap: .4rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: .45rem 1rem;
        color: var(--muted);
        font-size: .82rem;
        cursor: pointer;
        transition: all .2s;
    }
    .action-btn:hover { border-color: rgba(108,99,255,.3); color: var(--accent); }

    /* ── SIDEBAR ── */
    .sidebar {
        position: sticky;
        top: 90px;
    }
    .sidebar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .sidebar-title {
        font-family: 'Syne', sans-serif;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    .trend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .5rem 0;
        border-bottom: 1px solid var(--border);
    }
    .trend-item:last-child { border: none; }
    .trend-tag {
        font-weight: 600;
        font-size: .85rem;
        color: var(--accent);
    }
    .trend-count {
        font-size: .75rem;
        color: var(--muted);
    }

    .suggest-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-bottom: .85rem;
    }
    .suggest-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .8rem;
        color: #fff;
        flex-shrink: 0;
    }
    .suggest-info { flex: 1; }
    .suggest-name { font-weight: 600; font-size: .85rem; }
    .suggest-role { font-size: .73rem; color: var(--muted); }
    .follow-btn {
        background: none;
        border: 1px solid rgba(108,99,255,.5);
        color: var(--accent);
        border-radius: 8px;
        padding: .3rem .7rem;
        font-size: .75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
    }
    .follow-btn:hover {
        background: var(--accent);
        color: #fff;
    }

    .divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 1rem 0;
    }

    /* ── FEED LABEL ── */
    .feed-label {
        font-family: 'Syne', sans-serif;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .7rem;
    }
    .feed-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--muted);
        font-size: .9rem;
    }
    .empty-state svg { margin-bottom: 1rem; opacity: .3; }

    /* ── SCROLLBAR ── */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--surface2); border-radius: 99px; }


    .comment-item {
    display: flex;
    align-items: flex-start;
    gap: .65rem;
    margin-bottom: .75rem;
}
.comment-avatar {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: .72rem;
    color: #fff;
    flex-shrink: 0;
}
.comment-author {
    font-size: .75rem;
    font-weight: 600;
    color: var(--text2);
    margin-bottom: .15rem;
}
.comment-text {
    font-size: .83rem;
    color: #9ca3af;
    line-height: 1.5;
}
.comment-delete {
    background: none;
    border: none;
    color: var(--muted);
    font-size: .75rem;
    cursor: pointer;
    padding: .2rem .4rem;
    border-radius: 5px;
    transition: color .2s, background .2s;
}
.comment-delete:hover { color: var(--accent2); background: rgba(233,69,96,.08); }
.comment-form {
    display: flex;
    gap: .5rem;
    margin-top: .75rem;
}
.comment-input {
    flex: 1;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 999px;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: .83rem;
    padding: .5rem 1rem;
    outline: none;
    transition: border-color .2s;
}
.comment-input:focus { border-color: rgba(108,99,255,.4); }
.comment-input::placeholder { color: var(--muted); }
.comment-submit {
    background: var(--accent);
    border: none;
    border-radius: 50%;
    width: 34px; height: 34px;
    color: #fff;
    font-size: .9rem;
    cursor: pointer;
    flex-shrink: 0;
    transition: opacity .2s;
}
.comment-submit:hover { opacity: .85; }
</style>

<div class="feed-wrapper">
    <div class="row g-4">

        <!-- ══════════ COLONNE PRINCIPALE ══════════ -->
        <div class="col-lg-8">

            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-badge">
                    <span class="dot"></span>
                    En ligne
                </div>
            </div>

            <!-- STORY UPLOAD -->
            <div class="g-card">
                <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" id="storyForm">
                    @csrf
                    <div class="story-upload">
                        <label for="storyFile">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Nouvelle Story
                        </label>
                        <input type="file" name="image" id="storyFile" accept="image/*"
                               onchange="document.getElementById('storyForm').submit()">
                        <span class="upload-hint">Choisir une <span>image</span> à partager</span>
                    </div>
                </form>
            </div>

            <!-- STORIES STRIP -->
            @if($stories->count())
            <div class="g-card">
                <div class="stories-strip">
                    <div class="stories-strip-label">Stories actives</div>
                    <div class="stories-row">
                        @foreach($stories as $story)
                        <a href="{{ route('stories.show', $story->id_story) }}" class="story-item">
                            <div class="story-ring">
                                <div class="story-ring-inner">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b6/Image_created_with_a_mobile_phone.png"
                                         alt="{{ $story->user->first_name }}">
                                </div>
                            </div>
                            <span class="story-name">{{ $story->user->first_name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- COMPOSE BOX -->
            <div class="g-card">
                <div class="compose-box">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="compose-header">
                            <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</div>
                            <div class="compose-placeholder">
                                <span style="font-size:.82rem; color:var(--muted);">Partager quelque chose…</span>
                            </div>
                        </div>
                        <textarea name="content" class="compose-textarea"
                                  placeholder="Quoi de neuf, {{ auth()->user()->first_name }} ? Exprime-toi…"
                                  rows="3" required></textarea>
                        <div class="compose-footer">
                            <!-- <div class="compose-actions">
                                <button type="button" class="compose-action-btn" title="Photo">📷 Photo</button>
                                <button type="button" class="compose-action-btn" title="Humeur">😊 Humeur</button>
                            </div> -->
                            <button type="submit" class="publish-btn">Publier →</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FIL D'ACTUALITÉ -->
            <div class="feed-label">Fil d'actualité</div>

            @forelse($posts as $post)
            <div class="post-card">
                <div class="post-header">
                    <div class="avatar-post">
                        {{ strtoupper(substr($post->user->first_name, 0, 1)) }}
                    </div>
                    <div class="post-meta">
                        <div class="post-author">{{ $post->user->first_name }} {{ $post->user->last_name }}</div>
                        <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                    <button class="post-options" title="Options">···</button>
                </div>

                <div class="post-body">
                    {{ $post->content }}
                </div>

                <div class="post-footer">
    {{-- Like --}}
    <form action="{{ url('posts/'.$post->post_id.'/like') }}" method="POST" class="like-form">
        @csrf
        <button type="submit" class="like-btn {{ $post->isLikedBy(auth()->id() ?? 1) ? 'liked' : '' }}">
            ❤ <span>{{ $post->likes->count() }}</span>
        </button>
    </form>

    {{-- Toggle commentaires --}}
    <button type="button" class="action-btn" onclick="toggleComments({{ $post->post_id }})">
        💬 {{ $post->comments->count() }}
    </button>

    <!-- <button type="button" class="action-btn">↗ Partager</button> -->
</div>

{{-- Section commentaires --}}
<div id="comments-{{ $post->post_id }}" style="display:none; padding: 0 1.4rem 1rem;">
    <hr class="divider">

    @foreach($post->comments as $comment)
    <div class="comment-item">
        <div class="comment-avatar">
            {{ strtoupper(substr($comment->user->first_name, 0, 1)) }}
        </div>
        <div class="comment-body">
            <div class="comment-author">{{ $comment->user->first_name }}</div>
            <div class="comment-text">{{ $comment->content }}</div>
        </div>
        @if($comment->user_id === auth()->id())
        <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST" style="margin-left:auto">
            @csrf @method('DELETE')
            <button type="submit" class="comment-delete">✕</button>
        </form>
        @endif
    </div>
    @endforeach

    <form action="{{ route('comments.store', $post->post_id) }}" method="POST" class="comment-form">
        @csrf
        <input type="text" name="content" placeholder="Écrire un commentaire…" required class="comment-input">
        <button type="submit" class="comment-submit">→</button>
    </form>
</div>
            </div>
            @empty
            <div class="empty-state">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p>Aucun post pour l'instant.<br>Sois le premier à partager quelque chose !</p>
            </div>
            @endforelse

        </div>

        <!-- ══════════ SIDEBAR ══════════ -->
        <div class="col-lg-4 d-none d-lg-block">
            <div class="sidebar">

                <!-- TRENDING -->
                <!-- <div class="sidebar-card">
                    <div class="sidebar-title">Tendances</div>
                    <div class="trend-item">
                        <span class="trend-tag">#dev</span>
                        <span class="trend-count">1.2k posts</span>
                    </div>
                    <div class="trend-item">
                        <span class="trend-tag">#cloud</span>
                        <span class="trend-count">843 posts</span>
                    </div>
                    <div class="trend-item">
                        <span class="trend-tag">#marrakech</span>
                        <span class="trend-count">576 posts</span>
                    </div>
                    <div class="trend-item">
                        <span class="trend-tag">#laravel</span>
                        <span class="trend-count">312 posts</span>
                    </div>
                </div> -->

                <!-- SUGGESTIONS -->
                <!-- <div class="sidebar-card">
                    <div class="sidebar-title">Suggestions</div>

                    <div class="suggest-item">
                        <div class="suggest-avatar" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">A</div>
                        <div class="suggest-info">
                            <div class="suggest-name">Amine B.</div>
                            <div class="suggest-role">DevOps Engineer</div>
                        </div>
                        <button class="follow-btn">Suivre</button>
                    </div>

                    <div class="suggest-item">
                        <div class="suggest-avatar" style="background: linear-gradient(135deg, #10b981, #06b6d4);">Y</div>
                        <div class="suggest-info">
                            <div class="suggest-name">Youssef M.</div>
                            <div class="suggest-role">Full-Stack Dev</div>
                        </div>
                        <button class="follow-btn">Suivre</button>
                    </div>

                </div> -->


            </div>
        </div>

    </div>
</div>

@endsection
<script>
function toggleComments(postId) {
    const el = document.getElementById('comments-' + postId);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>