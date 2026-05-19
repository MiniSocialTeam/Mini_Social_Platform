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
        --gold:     #f5c842;
        --text:     #455d7a;
        --muted:    #6b7280;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    /* Noise */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: .5;
    }

    /* Ambient orbs — accent2 dominant côté gauche cette fois */
    body::after {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse 50% 50% at 85% 10%, rgba(233,69,96,0.11) 0%, transparent 70%),
            radial-gradient(ellipse 45% 45% at 10% 90%, rgba(108,99,255,0.13) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    /* ── SPLIT LAYOUT ── */
    .reg-page {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* ── LEFT — FORM PANEL ── */
    .reg-left {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 2rem;
        border-right: 1px solid var(--border);
    }
    .reg-box {
        width: 100%;
        max-width: 420px;
        animation: fade-up .45s both;
    }

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .reg-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.75rem;
        letter-spacing: -.8px;
        margin-bottom: .3rem;
    }
    .reg-subtitle {
        font-size: .87rem;
        color: var(--muted);
        margin-bottom: 1.75rem;
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
    .error-alert ul { padding-left: 1.1rem; }

    /* Name row side by side */
    .name-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .85rem;
    }

    /* Fields */
    .field { margin-bottom: 1.15rem; }
    .field label {
        display: block;
        font-size: .75rem;
        font-weight: 500;
        color: var(--muted);
        letter-spacing: .5px;
        text-transform: uppercase;
        margin-bottom: .4rem;
    }
    .field-wrap { position: relative; }
    .field-icon {
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
        padding: .78rem 1rem .78rem 2.7rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .field input::placeholder { color: var(--muted); }
    .field input:focus {
        border-color: rgba(108,99,255,.5);
        box-shadow: 0 0 0 3px rgba(108,99,255,.08);
    }
    .field input.is-invalid {
        border-color: rgba(233,69,96,.45);
        box-shadow: 0 0 0 3px rgba(233,69,96,.07);
    }

    /* Strength bar */
    .strength-wrap { margin-top: .5rem; }
    .strength-bar {
        height: 3px;
        border-radius: 99px;
        background: var(--border);
        overflow: hidden;
    }
    .strength-bar-fill {
        height: 100%;
        border-radius: 99px;
        width: 0%;
        transition: width .3s, background .3s;
    }
    .strength-label {
        font-size: .7rem;
        color: var(--muted);
        margin-top: .3rem;
        min-height: 1em;
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

    /* Match indicator */
    .match-hint {
        font-size: .72rem;
        margin-top: .35rem;
        min-height: 1em;
        transition: color .2s;
    }

    /* Submit */
    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--accent2), #f97316);
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
        box-shadow: 0 4px 20px rgba(233,69,96,.35);
        margin-top: .5rem;
        margin-bottom: 1.5rem;
    }
    .submit-btn:hover {
        opacity: .9;
        transform: translateY(-1px);
        box-shadow: 0 6px 28px rgba(233,69,96,.45);
    }
    .submit-btn:active { transform: translateY(0); }

    /* Or + login link */
    .or-divider {
        display: flex;
        align-items: center;
        gap: .8rem;
        margin-bottom: 1.4rem;
        color: var(--muted);
        font-size: .78rem;
    }
    .or-divider::before, .or-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }
    .login-row {
        text-align: center;
        font-size: .85rem;
        color: var(--muted);
    }
    .login-row a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 600;
        transition: opacity .2s;
    }
    .login-row a:hover { opacity: .75; }

    /* ── RIGHT — BRAND PANEL ── */
    .reg-right {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem 3.5rem;
        position: relative;
        overflow: hidden;
    }
    .reg-right::after {
        content: '';
        position: absolute;
        bottom: -100px; right: -100px;
        width: 360px; height: 360px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(233,69,96,0.15), transparent 70%);
        pointer-events: none;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: .65rem;
        text-decoration: none;
        position: relative;
        z-index: 1;
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

    .right-hero {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 1;
    }
    .right-tagline {
        font-family: 'Syne', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -1.5px;
        margin-bottom: 1.1rem;
    }
    .right-tagline .grad {
        background: linear-gradient(135deg, var(--accent2), var(--gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .right-sub {
        font-size: .9rem;
        color: var(--muted);
        line-height: 1.7;
        max-width: 330px;
        margin-bottom: 2.5rem;
    }

    /* Stats row */
    .stats-row {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .stat-box {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: .9rem 1.2rem;
        animation: slide-in .5s both;
    }
    .stat-box:nth-child(1) { animation-delay: .1s; }
    .stat-box:nth-child(2) { animation-delay: .2s; }
    .stat-box:nth-child(3) { animation-delay: .3s; }
    @keyframes slide-in {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 1.4rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--accent2), var(--gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .stat-label {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .15rem;
    }

    /* Testimonial card */
    .testimonial {
        margin-top: 2rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.1rem 1.3rem;
        max-width: 340px;
        position: relative;
        animation: slide-in .5s .4s both;
    }
    .testimonial::before {
        content: '"';
        position: absolute;
        top: -.5rem; left: 1rem;
        font-size: 3rem;
        font-family: 'Syne', sans-serif;
        color: var(--accent2);
        line-height: 1;
        opacity: .5;
    }
    .testimonial-text {
        font-size: .83rem;
        color: #9ca3af;
        line-height: 1.65;
        margin-bottom: .75rem;
        padding-top: .5rem;
    }
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: .55rem;
    }
    .testi-avatar {
        width: 30px; height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: .72rem;
        font-weight: 800;
        color: #fff;
    }
    .testi-name { font-size: .78rem; font-weight: 600; }
    .testi-role { font-size: .7rem; color: var(--muted); }

    .right-footer {
        font-size: .72rem;
        color: var(--muted);
        opacity: .5;
        position: relative;
        z-index: 1;
    }

    /* ── MOBILE ── */
    @media (max-width: 768px) {
        .reg-page { grid-template-columns: 1fr; }
        .reg-right { display: none; }
        .reg-left { padding: 2rem 1.25rem; min-height: 100vh; align-items: flex-start; padding-top: 3rem; }
    }
</style>

<div class="reg-page">

    <!-- ══ LEFT — FORM ══ -->
    <div class="reg-left">
        <div class="reg-box">

            <div class="reg-title">Créer un compte ✦</div>
            <p class="reg-subtitle">Rejoins la communauté en quelques secondes</p>

            @if ($errors->any())
            <div class="error-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Prénom + Nom -->
                <div class="name-row">
                    <div class="field">
                        <label for="first_name">Prénom</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input id="first_name" type="text" name="first_name"
                                   value="{{ old('first_name') }}"
                                   placeholder=""
                                   required autofocus
                                   class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}">
                        </div>
                    </div>
                    <div class="field">
                        <label for="last_name">Nom</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input id="last_name" type="text" name="last_name"
                                   value="{{ old('last_name') }}"
                                   placeholder=""
                                   required
                                   class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="field">
                    <label for="email">Adresse e-mail</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="toi@exemple.com"
                               required autocomplete="email"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    </div>
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">Mot de passe</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="password" type="password" name="password"
                               placeholder=""
                               required autocomplete="new-password"
                               oninput="checkStrength(this.value)"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        <button type="button" class="toggle-pw" onclick="togglePw('password','eye1')" title="Afficher">
                            <svg id="eye1" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Strength meter -->
                    <div class="strength-wrap">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strength-fill"></div>
                        </div>
                        <div class="strength-label" id="strength-label"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="field">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="field-wrap">
                        <span class="field-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               placeholder=""
                               required autocomplete="new-password"
                               oninput="checkMatch()">
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eye2')" title="Afficher">
                            <svg id="eye2" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <div class="match-hint" id="match-hint"></div>
                </div>

                <button type="submit" class="submit-btn">Créer mon compte →</button>

            </form>

            <div class="or-divider">ou</div>

            <div class="login-row">
                Déjà inscrit ?
                <a href="{{ route('login') }}">Se connecter</a>
            </div>

        </div>
    </div>

    <!-- ══ RIGHT — BRAND ══ -->
    <div class="reg-right">

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

        <div class="right-hero">
            <div class="right-tagline">
                Ton espace.<br>
                Ta voix.<br>
                <span class="grad">Ton réseau.</span>
            </div>
            <p class="right-sub">
                Des milliers d'étudiants et de professionnels partagent déjà leurs idées ici. À ton tour.
            </p>

            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-value">12k+</div>
                    <div class="stat-label">Membres actifs</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">48k</div>
                    <div class="stat-label">Posts publiés</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">∞</div>
                    <div class="stat-label">Connexions</div>
                </div>
            </div>

            <div class="testimonial">
                <p class="testimonial-text">
                    Ce réseau m'a permis de trouver mon stage DevOps en moins de 2 semaines. La communauté est incroyable.
                </p>
                <div class="testimonial-author">
                    <div class="testi-avatar">Y</div>
                    <div>
                        <div class="testi-name">Youssef M.</div>
                        <div class="testi-role">Étudiant IRISI · UCA Marrakech</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-footer">© 2025 Connexion · Tous droits réservés</div>

    </div>

</div>

<script>
    /* Password visibility toggle */
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
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
        checkMatch();
    }

    /* Strength meter */
    function checkStrength(val) {
        const fill  = document.getElementById('strength-fill');
        const label = document.getElementById('strength-label');
        let score = 0;
        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))    score++;

        const levels = [
            { pct: '0%',   color: 'transparent', text: '' },
            { pct: '30%',  color: '#ef4444',      text: '⚠ Trop faible' },
            { pct: '55%',  color: '#f97316',      text: '○ Faible' },
            { pct: '80%',  color: '#eab308',      text: '◎ Correct' },
            { pct: '100%', color: '#22c55e',       text: '✓ Fort' },
        ];
        const l = levels[score];
        fill.style.width      = l.pct;
        fill.style.background = l.color;
        label.textContent     = l.text;
        label.style.color     = l.color;
        checkMatch();
    }

    /* Match indicator */
    function checkMatch() {
        const pw   = document.getElementById('password').value;
        const conf = document.getElementById('password_confirmation').value;
        const hint = document.getElementById('match-hint');
        if (!conf) { hint.textContent = ''; return; }
        if (pw === conf) {
            hint.textContent = '✓ Les mots de passe correspondent';
            hint.style.color = '#22c55e';
        } else {
            hint.textContent = '✗ Les mots de passe ne correspondent pas';
            hint.style.color = '#ef4444';
        }
    }
</script>

@endsection