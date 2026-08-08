<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Member | MerahPutihPers')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        .member-sidebar {
            background: #1a1a2e;
            min-height: 100vh;
            color: #fff;
        }

        .member-sidebar .brand {
            padding: 20px;
            font-size: 20px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .member-sidebar .brand a {
            color: #fff;
            text-decoration: none;
        }

        .member-sidebar .nav-link {
            color: #ccc;
            padding: 12px 20px;
            border-radius: 0;
            transition: 0.2s;
        }

        .member-sidebar .nav-link:hover,
        .member-sidebar .nav-link.active {
            background: #d90429;
            color: #fff;
        }

        .member-topbar {
            background: #fff;
            padding: 15px 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .member-content {
            padding: 25px;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .stat-card .icon {
            font-size: 32px;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <aside class="col-md-3 col-lg-2 member-sidebar p-0">
                <div class="brand">
                    <a href="{{ url('/') }}">MerahPutihPers</a>
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                            href="{{ route('member.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.profile') ? 'active' : '' }}"
                            href="{{ route('member.profile') }}">
                            <i class="fas fa-user"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.bookmarks') ? 'active' : '' }}"
                            href="{{ route('member.bookmarks') }}">
                            <i class="fas fa-bookmark"></i> Bookmark
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.likes') ? 'active' : '' }}"
                            href="{{ route('member.likes') }}">
                            <i class="fas fa-heart"></i> Favorit
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.history') ? 'active' : '' }}"
                            href="{{ route('member.history') }}">
                            <i class="fas fa-history"></i> Riwayat Baca
                        </a>
                    </li>
<li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.comments') ? 'active' : '' }}"
                            href="{{ route('member.comments') }}">
                            <i class="fas fa-comments"></i> Komentar Saya
                        </a>
                    </li>
                    <div class="sb-sidenav-menu-heading px-3 mt-3 text-uppercase small text-white-50">Premium</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.subscriptions.*') ? 'active' : '' }}"
                            href="{{ route('member.subscriptions.index') }}">
                            <i class="fas fa-crown"></i> Langganan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member.koran.*') ? 'active' : '' }}"
                            href="{{ route('member.koran.index') }}">
                            <i class="fas fa-file-pdf"></i> Koran Digital
                        </a>
                    </li>
                </ul>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-home"></i> Lihat Website</a>
                    </li>
                </ul>
            </aside>

            {{-- Main --}}
            <main class="col-md-9 col-lg-10 p-0">
                <div class="member-topbar">
                    <div>
                        <strong>Member Area</strong>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ Auth::guard('member')->user()->avatar_base64 ?? asset('default-avatar.png') }}"
                            class="avatar-circle" alt="avatar">
                        <span class="me-2">{{ Auth::guard('member')->user()->name }}</span>
                        <form method="POST" action="{{ route('member.logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    </div>
                </div>

                <div class="member-content">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
