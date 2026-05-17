@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    :root {
        --bg:       #0d0f14;
        --surface:  #13161e;
        --surface2: #1a1e2a;
        --border:   rgba(255,255,255,0.07);
        --accent:   #6c63ff;
        --accent2:  #e94560;
        --text:     #455d7a;
        --muted:    #6b7280;
        --glow:     0 0 60px rgba(108,99,255,0.18);
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        margin: 0;
    }

    /* Noise grain */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: .5;
    }

    /* Ambient orbs */
    body::after {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse 55% 45% at 15% 10%, rgba(108,99,255,0.12) 0%, transparent 70%),
            radial-gradient(ellipse 40% 40% at 85% 90%, rgba(233,69,96,0.09) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    /* ── LAYOUT ── */
    .login-page {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* ── LEFT PANEL ── */
    .login-left {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem 3.5rem;
        border-right: 1px solid var(--border);
        position: relative;
        overflow: hidden;
    }
    .login-left::before {
        content: '';
        position: absolute;
        top: -80px; left: -80px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(108,99,255,0.18), transparent 70%);
        pointer-events: none;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: .65rem;
        text-decoration: none;
    }
    .brand-icon {
        width: 38px; height: 38px;
        border-radius: 11px;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex; align-items: center; justify-content: center;
    }
    .brand-name {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--text);
        letter-spacing: -.5px;
    }

    .left-hero {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem 0;
    }
    .left-tagline {
        font-family: 'Syne', sans-serif;
        font-size: 2.6rem;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -1.5px;
        margin-bottom: 1.1rem;
    }
    .left-tagline .grad {
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .left-sub {
        font-size: .92rem;
        color: var(--muted);
        line-height: 1.7;
        max-width: 340px;
        margin-bottom: 2.5rem;
    }

    /* Floating feature pills */
    .feature-pills {
        display: flex;
        flex-direction: column;
        gap: .65rem;
    }
    .feature-pill {
        display: inline-flex;
        align-items: center;
        gap: .65rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: .65rem 1rem;
        font-size: .82rem;
        color: var(--muted);
        max-width: fit-content;
        animation: slide-in .5s both;
    }
    .feature-pill:nth-child(1) { animation-delay: .15s; }
    .feature-pill:nth-child(2) { animation-delay: .25s; }
    .feature-pill:nth-child(3) { animation-delay: .35s; }
    .feature-pill .pill-icon {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem;
    }
    .feature-pill .pill-text strong {
        display: block;
        color: var(--text);
        font-weight: 500;
        font-size: .84rem;
    }

    @keyframes slide-in {
        from { opacity: 0; transform: translateX(-12px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .left-footer {
        font-size: .72rem;
        color: var(--muted);
        opacity: .6;
    }

    /* ── RIGHT PANEL ── */
    .login-right {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 2rem;
    }
    .login-box {
        width: 100%;
        max-width: 400px;
        animation: fade-up .45s both;
    }
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .login-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.75rem;
        letter-spacing: -.8px;
        margin-bottom: .35rem;
    }
    .login-subtitle {
        font-size: .87rem;
        color: var(--muted);
        margin-bottom: 2rem;
    }

    /* Error alert */
    .error-alert {
        background: rgba(233,69,96,.1);
        border: 1px solid rgba(233,69,96,.25);
        border-radius: 12px;
        padding: .85rem 1rem;
        margin-bottom: 1.5rem;
        font-size: .83rem;
        color: #f87191;
    }
    .error-alert ul { margin: 0; padding-left: 1.1rem; }

    /* Form fields */
    .field {
        margin-bottom: 1.25rem;
    }
    .field label {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        color: var(--muted);
        letter-spacing: .5px;
        text-transform: uppercase;
        margin-bottom: .45rem;
    }
    .field-wrap {
        position: relative;
    }
    .field-wrap .field-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
        display: flex;
    }
    .field input {
        width: 100%;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        padding: .8rem 1rem .8rem 2.75rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }
    .field input::placeholder { color: var(--muted); }
    .field input:focus {
        border-color: rgba(108,99,255,.5);
        box-shadow: 0 0 0 3px rgba(108,99,255,.1);
    }

    /* Password toggle */
    .toggle-pw {
        position: absolute;
        right: .9rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        padding: .2rem;
        display: flex;
        transition: color .2s;
    }
    .toggle-pw:hover { color: var(--text); }

    /* Remember row */
    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.75rem;
    }
    .remember-check {
        display: flex;
        align-items: center;
        gap: .55rem;
        cursor: pointer;
        font-size: .83rem;
        color: var(--muted);
        user-select: none;
    }
    .remember-check input[type=checkbox] {
        appearance: none;
        width: 16px; height: 16px;
        border: 1.5px solid var(--muted);
        border-radius: 5px;
        background: var(--surface2);
        cursor: pointer;
        position: relative;
        transition: background .2s, border-color .2s;
        flex-shrink: 0;
    }
    .remember-check input[type=checkbox]:checked {
        background: var(--accent);
        border-color: var(--accent);
    }
    .remember-check input[type=checkbox]:checked::after {
        content: '';
        position: absolute;
        left: 3px; top: 1px;
        width: 5px; height: 9px;
        border: 2px solid #fff;
        border-top: none;
        border-left: none;
        transform: rotate(45deg);
    }
    .forgot-link {
        font-size: .8rem;
        color: var(--accent);
        text-decoration: none;
        transition: opacity .2s;
    }
    .forgot-link:hover { opacity: .75; }

    /* Submit button */
    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--accent), #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: .9rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .95rem;
        letter-spacing: .3px;
        cursor: pointer;
        transition: opacity .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 4px 20px rgba(108,99,255,.35);
        margin-bottom: 1.5rem;
    }
    .submit-btn:hover {
        opacity: .9;
        transform: translateY(-1px);
        box-shadow: 0 6px 28px rgba(108,99,255,.45);
    }
    .submit-btn:active { transform: translateY(0); }

    /* Divider */
    .or-divider {
        display: flex;
        align-items: center;
        gap: .8rem;
        margin-bottom: 1.5rem;
        color: var(--muted);
        font-size: .78rem;
    }
    .or-divider::before, .or-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* Register link */
    .register-row {
        text-align: center;
        font-size: .85rem;
        color: var(--muted);
    }
    .register-row a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 600;
        transition: opacity .2s;
    }
    .register-row a:hover { opacity: .75; }

    /* ── MOBILE ── */
    @media (max-width: 768px) {
        .login-page { grid-template-columns: 1fr; }
        .login-left { display: none; }
        .login-right { padding: 2rem 1.25rem; min-height: 100vh; }
    }
</style>

<div class="login-page">

    <!-- ══ LEFT ══ -->
    <div class="login-left">
        <a href="/" class="brand">
            <div class="brand-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span class="brand-name">Connexion</span>
        </a>

        <div class="left-hero">
            <div class="left-tagline">
                Connecte-toi.<br>
                Partage.<br>
                <span class="grad">Grandis.</span>
            </div>
            <p class="left-sub">
                Rejoins une communauté qui partage tes passions, tes projets, et tes ambitions.
            </p>

            <div class="feature-pills">
                <div class="feature-pill">
                    <div class="pill-icon" style="background:rgba(108,99,255,.15);">✨</div>
                    <div class="pill-text">
                        <strong>Stories éphémères</strong>
                        Partage tes moments en 24h
                    </div>
                </div>
                <div class="feature-pill">
                    <div class="pill-icon" style="background:rgba(233,69,96,.12);">❤️</div>
                    <div class="pill-text">
                        <strong>Réactions en temps réel</strong>
                        Like, commente, interagis
                    </div>
                </div>
                <div class="feature-pill">
                    <div class="pill-icon" style="background:rgba(245,200,66,.12);">🚀</div>
                    <div class="pill-text">
                        <strong>Fil personnalisé</strong>
                        Du contenu qui te ressemble
                    </div>
                </div>
            </div>
        </div>

        <div class="left-footer">© 2025 Connexia · Tous droits réservés</div>
    </div>

    <!-- ══ RIGHT ══ -->
    <div class="login-right">
        <div class="login-box">

            <div class="login-title">Bon retour 👋</div>
            <p class="login-subtitle">Connecte-toi à ton espace</p>

            @if ($errors->any())
            <div class="error-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field">
                    <label for="email">Adresse e-mail</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="toi@exemple.com"
                               required autofocus autocomplete="email">
                    </div>
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">Mot de passe</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="password" type="password" name="password"
                               placeholder=""
                               required autocomplete="current-password">
                        <button type="button" class="toggle-pw" onclick="togglePw()" title="Afficher">
                            <svg id="eye-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="remember-row">
                    <label class="remember-check">
                        <input type="checkbox" id="remember" name="remember">
                        Se souvenir de moi
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="submit-btn">
                    Se connecter →
                </button>

            </form>

            <div class="or-divider">ou</div>

            <div class="register-row">
                Pas encore inscrit ?
                <a href="{{ route('register') }}">Créer un compte</a>
            </div>

        </div>
    </div>

</div>

<script>
    function togglePw() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>`;
        }
    }
</script>

@endsection