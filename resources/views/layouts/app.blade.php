<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexia — Social</title>

    <!-- Bootstrap (grid + utilities uniquement, on override le style) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

        :root {
            --bg:       #0d0f14;
            --surface:  #13161e;
            --surface2: #1a1e2a;
            --border:   rgba(255,255,255,0.07);
            --accent:   #6c63ff;
            --accent2:  #e94560;
            --text:     #f0f1f5;
            --text2:    #f5f6fa;
            --muted:    #6b7280;
            --nav-h:    62px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            /* décale le contenu sous la navbar fixe */
            padding-top: var(--nav-h);
        }

        /* ── NOISE TEXTURE ── */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0; opacity: .5;
        }

        /* ── NAVBAR ── */
        .topnav {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--nav-h);
            z-index: 1000;
            background: rgba(13,15,20,0.85);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
        }
        .topnav-inner {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nav-brand-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
        }
        .nav-brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: -.4px;
            color: var(--text2);
        }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: .25rem;
            flex: 1;
        }
        .nav-link-item {
            display: flex;
            align-items: center;
            gap: .45rem;
            padding: .45rem .85rem;
            border-radius: 9px;
            font-size: .875rem;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: background .2s, color .2s;
            white-space: nowrap;
        }
        .nav-link-item:hover {
            background: var(--surface2);
            color: var(--text);
        }
        .nav-link-item.active {
            background: rgba(108,99,255,.12);
            color: var(--accent);
        }
        .nav-link-item svg { flex-shrink: 0; }

        /* Right side */
        .nav-right {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-left: auto;
        }

        /* Avatar nav */
        .nav-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: .8rem;
            color: #fff;
            text-decoration: none;
            border: 2px solid transparent;
            transition: border-color .2s;
        }
        .nav-avatar:hover { border-color: var(--accent); }

        /* Logout button */
        .nav-logout {
            display: flex;
            align-items: center;
            gap: .4rem;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--muted);
            padding: .4rem .9rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 500;
            cursor: pointer;
            transition: border-color .2s, color .2s, background .2s;
        }
        .nav-logout:hover {
            border-color: rgba(233,69,96,.35);
            color: var(--accent2);
            background: rgba(233,69,96,.06);
        }

        /* Guest buttons */
        .nav-btn-ghost {
            padding: .42rem .9rem;
            border-radius: 9px;
            font-size: .84rem;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            border: 1px solid var(--border);
            transition: color .2s, border-color .2s;
        }
        .nav-btn-ghost:hover { color: var(--text); border-color: rgba(255,255,255,.15); }

        .nav-btn-primary {
            padding: .42rem 1rem;
            border-radius: 9px;
            font-size: .84rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            transition: opacity .2s, transform .15s;
            box-shadow: 0 2px 12px rgba(108,99,255,.3);
        }
        .nav-btn-primary:hover { opacity: .88; transform: translateY(-1px); color: #fff; }

        /* ── HAMBURGER (mobile) ── */
        .nav-toggler {
            display: none;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .4rem .55rem;
            cursor: pointer;
            color: var(--muted);
            margin-left: auto;
        }
        .nav-toggler:hover { color: var(--text); }

        /* Mobile menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: var(--nav-h);
            left: 0; right: 0;
            background: rgba(13,15,20,0.97);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.5rem 1.5rem;
            z-index: 999;
            flex-direction: column;
            gap: .4rem;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu .nav-link-item { padding: .65rem 1rem; }
        .mobile-menu-sep {
            border: none;
            border-top: 1px solid var(--border);
            margin: .5rem 0;
        }

        /* ── FLASH MESSAGE ── */
        .flash-wrap {
            position: fixed;
            top: calc(var(--nav-h) + 1rem);
            right: 1.5rem;
            z-index: 1100;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }
        .flash {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .75rem 1.1rem;
            border-radius: 12px;
            font-size: .85rem;
            font-weight: 500;
            max-width: 320px;
            animation: flash-in .3s both, flash-out .4s 3.5s both;
            border: 1px solid;
        }
        .flash-success {
            background: rgba(34,197,94,.1);
            border-color: rgba(34,197,94,.25);
            color: #4ade80;
        }
        .flash-error {
            background: rgba(233,69,96,.1);
            border-color: rgba(233,69,96,.25);
            color: #f87171;
        }
        @keyframes flash-in {
            from { opacity: 0; transform: translateX(16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes flash-out {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(16px); }
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            position: relative;
            z-index: 1;
        }

        /* ── RESET BOOTSTRAP conflicts ── */
        .container, .container-fluid { background: transparent !important; }
        a { color: inherit; }
        .navbar { display: none !important; } /* cache la navbar Bootstrap si elle était déjà là */

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--surface2); border-radius: 99px; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .nav-links, .nav-right { display: none; }
            .nav-toggler { display: flex; align-items: center; }
        }
    </style>
</head>
<body>

    <!-- ══════════ NAVBAR ══════════ -->
    <nav class="topnav" role="navigation" aria-label="Navigation principale">
        <div class="topnav-inner">

            <!-- Brand -->
            <!-- <a href="{{ auth()->check() ? route('home') : url('/') }}" class="nav-brand">
                <div class="nav-brand-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <span class="nav-brand-name">Connexia</span>
            </a> -->

            @auth
            <!-- Nav links -->
            <div class="nav-links">
                <a href="{{ route('home') }}"
                   class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Mini Social App
                </a>
                 <a href="{{ route('profile.show') }}" class="nav-avatar" title="Mon profil">
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                </a>
                <a href="{{ route('friends.requests') }}" class="nav-link-item {{ request()->routeIs('friends.*') ? 'active' : '' }}">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/>
    </svg>
    Connexions
</a>
<a href="{{ route('home') }}/chat" class="nav-link-item {{ request()->routeIs('home/chat') ? 'active' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
  <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
</svg>
    Chat
</a>
            </div>

            <!-- Right -->
            <div class="nav-right">
                <form method="POST" action="{{ route('logout') }}" style="display:contents">
                    @csrf
                    <button type="submit" class="nav-logout">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <button class="nav-toggler" onclick="toggleMenu()" aria-label="Menu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            @else
            <!-- Guest -->
            <div class="nav-right" style="display:flex">
                <a href="{{ route('login') }}"    class="nav-btn-ghost">Connexion</a>
                <a href="{{ route('register') }}" class="nav-btn-primary">S'inscrire</a>
            </div>
            @endauth

        </div>
    </nav>

    <!-- ── Mobile menu ── -->
    @auth
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('home') }}"
           class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}"
           onclick="toggleMenu()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Fil d'actualité
        </a>
        <a href="{{ route('profile.show') }}"
           class="nav-link-item {{ request()->routeIs('profile.*') ? 'active' : '' }}"
           onclick="toggleMenu()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Mon profil
        </a>
        <hr class="mobile-menu-sep">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-logout" style="width:100%;justify-content:center">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Déconnexion
            </button>
        </form>
    </div>
    @endauth

    <!-- ══════════ FLASH MESSAGES ══════════ -->
    <div class="flash-wrap">
        @if(session('success'))
        <div class="flash flash-success">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flash flash-error">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif
    </div>

    <!-- ══════════ CONTENU ══════════ -->
    <div class="page-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile menu toggle
        function toggleMenu() {
            const m = document.getElementById('mobileMenu');
            if (m) m.classList.toggle('open');
        }

        // Fermer menu si clic en dehors
        document.addEventListener('click', function(e) {
            const menu    = document.getElementById('mobileMenu');
            const toggler = document.querySelector('.nav-toggler');
            if (menu && menu.classList.contains('open')) {
                if (!menu.contains(e.target) && !toggler.contains(e.target)) {
                    menu.classList.remove('open');
                }
            }
        });

        // Auto-dismiss flash messages
        document.querySelectorAll('.flash').forEach(el => {
            setTimeout(() => el.remove(), 4000);
        });

        // Active link highlight (au cas où routeIs ne suffit pas)
        document.querySelectorAll('.nav-link-item').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>

</body>
</html>