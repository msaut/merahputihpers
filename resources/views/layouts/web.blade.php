<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'MerahPutihpers.com - Portal Berita Terkini, Faktual & Terpercaya')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="author" content="MerahPutihPers">
    <meta name="language" content="Indonesian">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    @hasSection('og_meta')
        @yield('og_meta')
    @else
        @php $defaultOgImage = asset('assets/img/logo/logo.png'); @endphp
        <meta name="description" content="MerahPutihPers - Portal berita online terkini, terpercaya, dan faktual." />
        <meta name="keywords" content="berita terkini, berita nasional, berita daerah, portal berita, jurnalistik" />
        <meta property="og:title" content="MerahPutihPers.com - Portal Berita Terkini & Terpercaya" />
        <meta property="og:description"
            content="MerahPutihPers - Portal berita online terkini, terpercaya, dan faktual untuk masyarakat Indonesia." />
        <meta property="og:image" content="{{ $defaultOgImage }}" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="MerahPutihPers" />
        <meta property="og:locale" content="id_ID" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="MerahPutihPers.com - Berita Terkini" />
        <meta name="twitter:description" content="Portal berita faktual dan bermanfaat untuk masyarakat." />
        <meta name="twitter:image" content="{{ $defaultOgImage }}" />
    @endif

    @php
        $adClient = config('services.adsense.client', 'ca-pub-9554143637851066');
        $adEnable = config('services.adsense.enable', true);
    @endphp

    @if ($adEnable && !empty($adClient))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adClient }}"
            crossorigin="anonymous"></script>
    @endif

    @php
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'MerahPutihPers',
            'url' => url('/'),
            'description' => 'Portal berita online terkini...',
            'inLanguage' => 'id-ID',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/search') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    @endphp

    <script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ticker-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        .footer-area {
            background: #000000;
            margin-top: 30px;
        }

        .footer-logo img {
            max-width: 180px;
        }

        .footer-pera p {
            color: #555;
            line-height: 1.6;
        }

        .footer-box {
            transition: 0.3s;
            height: 100%;
        }

        .footer-box:hover {
            transform: translateY(-5px);
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            color: #333;
            font-weight: 500;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: #d90429;
            padding-left: 5px;
        }

        .footer-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-col {
            flex: 1;
            min-width: 250px;
        }

        .footer-bottom-area {
            background: #111;
            color: #fff;
            padding: 15px 0;
        }

        .footer-copy-right p {
            margin: 0;
            font-size: 14px;
        }

        .header-modern {
            width: 100%;
            font-family: 'Poppins', sans-serif;
            position: sticky;
            top: -48px;
            z-index: 9999;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
            overflow: visible !important;
        }

        .top-bar {
            background: #000;
            color: #fff;
            padding: 10px 40px;
            font-size: 14px;
        }

        .top-bar .social a {
            color: #ccc;
            margin-left: 15px;
            transition: 0.3s;
        }

        .top-bar .social a:hover {
            color: #fff;
        }

.main-header {
            background: #fff;
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        body {
            padding-top: 0;
        }

        .header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
        }

        .logo img {
            height: 50px;
        }

        .nav-menu ul {
            display: flex;
            list-style: none;
            gap: 25px;
            margin: 0;
        }

        .nav-menu ul li a {
            text-decoration: none;
            color: #222;
            font-weight: 600;
            position: relative;
        }

        .nav-menu ul li a::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            background: #d90429;
            left: 0;
            bottom: -5px;
            transition: 0.3s;
        }

        .nav-menu ul li a:hover::after {
            width: 100%;
        }

        .search-box {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 30px;
            padding: 5px 15px;
        }

        .search-box input {
            border: none;
            outline: none;
            margin-left: 10px;
        }

        .container-fluid {
            padding-left: 50px;
            padding-right: 50px;
        }

        @media (max-width: 991px) {
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }

            .header-flex {
                padding: 10px 15px;
                position: relative;
            }

            .nav-menu {
                display: none;
            }

            .search-box {
                display: none;
            }

            .mobile_menu {
                display: block !important;
            }
        }

.mobile_menu {
            display: none;
            position: relative;
            z-index: 999;
            margin-left: auto;
            order: 3;
        }

        .slicknav_menu {
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
        }

.slicknav_btn {
            background-color: #d90429 !important;
            border-radius: 4px;
            padding: 8px 10px !important;
            margin: 0 !important;
            border: none !important;
            display: inline-block;
            vertical-align: middle;
            transform: translateY(12px);
        }

        .slicknav_menu .slicknav_icon-bar {
            background-color: #ffffff !important;
            height: 3px !important;
            width: 22px !important;
            margin: 4px 0 !important;
            display: block !important;
        }

        .slicknav_nav {
            background: #ffffff !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            margin-top: 15px !important;
            padding: 10px 0 !important;
            position: absolute;
            right: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        .slicknav_nav a {
            color: #222222 !important;
            font-weight: 600;
            padding: 10px 20px !important;
            font-size: 15px !important;
        }

        .slicknav_nav a:hover {
            color: #d90429 !important;
            background: #f8f9fa !important;
        }

        .top-social {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .top-social a img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            transition: 0.3s;
        }

        .top-social a:hover img {
            transform: scale(1.2);
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.5));
        }

        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
            z-index: 999;
            display: none;
            max-height: 250px;
            overflow-y: auto;
        }

        .search-dropdown a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #eee;
        }

        .search-dropdown a:hover {
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <header class="header-modern">
        <div class="top-bar">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="date">{{ date('l, d M Y') }}</div>
                <div class="top-social">
                    <a href="https://web.facebook.com/profile.php?id=61591466745591" target="_blank">
                        <img src="{{ asset('assets/img/news/icon-fb.png') }}" alt="fb">
                    </a>
                    <a href="https://www.instagram.com/merahputihpers/" target="_blank">
                        <img src="{{ asset('assets/img/news/icon-ins.png') }}" alt="ig">
                    </a>
                    <!-- NOTE: Escape '@' menjadi '@@' agar Blade tidak error -->
                    <a href="https://www.tiktok.com/@@merahputihpers" target="_blank">
                        <img src="{{ asset('assets/img/news/icon-ttk.png') }}" alt="tiktok">
                    </a>
                    <a href="https://youtube.com/@@merahputihpers" target="_blank">
                        <img src="{{ asset('assets/img/news/icon-yo.png') }}" alt="yt">
                    </a>

                   @if (\Illuminate\Support\Facades\Auth::guard('member')->check())
    @php $memberGuest = \Illuminate\Support\Facades\Auth::guard('member')->user(); @endphp

    {{-- Icon Member --}}
    <a href="{{ route('member.dashboard') }}"
       title="{{ $memberGuest->name }}"
       style="padding:3px 6px; font-size:12px; line-height:1;width: 30px; height: 30px;"
       class="btn btn-outline-light">
        <i class="fas fa-user"></i>
    </a>

    {{-- Logout kecil --}}
    <form method="POST" action="{{ route('member.logout') }}" class="d-inline">
        @csrf
        <button title="Logout"
            style="padding:3px 6px; font-size:12px; line-height:1;width: 30px; height: 30px;"
            class="btn btn-outline-danger">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </form>

@else
    {{-- Login kecil --}}
    <a href="{{ route('member.login') }}"
       title="Login"
       style="padding:3px 6px; font-size:12px; line-height:1; width: 30px; height: 30px;"
       class="btn btn-outline-danger">
        <i class="fas fa-user"></i>
    </a>
@endif
                </div>
            </div>
        </div>

        <div class="main-header">
            <div class="container-fluid header-flex">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
                    </a>
                </div>
                <nav class="nav-menu">
                    <ul id="navigation">
                        <li><a href="/">Home</a></li>
                        @php $kategoriList = \App\Models\Kategori::all(); @endphp
                        @foreach ($kategoriList as $kategoriItem)
                            <li>
                                <a
                                    href="{{ route('web.kategori', $kategoriItem->id) }}">{{ $kategoriItem->nama }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <form action="{{ route('web.search') }}" method="GET" class="search-box"
                    style="position: relative;">

                    <input type="text" id="search-input" name="q" placeholder="Cari berita..."
                        value="{{ request('q') }}" autocomplete="off">

                    <button type="submit"
                        style="background: transparent; border: none; padding: 0; cursor: pointer; color: #555;">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Dropdown hasil -->
                    <div id="search-result" class="search-dropdown"></div>
                </form>
                <div class="mobile_menu"></div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="footer-row">
                    <div class="footer-col">
                        <div class="footer-logo mb-3">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/logo.png') }}"
                                    alt=""></a>
                        </div>
                        <div class="footer-pera">
                            <p>Merah Putih Pers hadir untuk memberikan penerangan terhadap berita yang baik, faktual,
                                dan bermanfaat bagi masyarakat. Kami menjaga etika jurnalistik demi kebenaran publik.
                            </p>
                        </div>
                    </div>
                    <div class="footer-col">
                        <div class="footer-box p-4 rounded shadow-sm bg-white">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Terms & Policy</h5>
                            <ul class="list-unstyled footer-links mb-4">
                                <li><a href="{{ route('static.terms-of-use') }}">Terms of Use</a></li>
                                <li><a href="{{ route('static.privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('static.contact') }}">Contact</a></li>
                            </ul>
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Rekanan</h5>
                            <ul class="list-unstyled footer-links">
                                @php
                                    $rekanans = \App\Models\Rekanan::active()->ordered()->get();
                                @endphp
                                @forelse ($rekanans as $rekanan)
                                    <li><a href="{{ $rekanan->url }}" target="_blank" rel="noopener noreferrer">{{ $rekanan->name }}</a></li>
                                @empty
                                    <li class="text-muted small">Belum ada data rekanan.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="footer-col">
                        <div class="footer-box p-4 rounded shadow-sm bg-white">
                            <h5 class="fw-bold mb-3">Newsletter</h5>
                            <p>Subscribe untuk update berita terbaru</p>
                            <form class="subscribe_form">
                                <input type="email" placeholder="Email Address" class="form-control mb-2">
                                <button class="btn btn-danger w-100">Subscribe</button>
                            </form>
                            <div class="mt-3">
                                <x-banner position="square" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-area">
            <div class="container text-center">
                <div class="footer-copy-right">
                    <p>Copyright &copy; {{ date('Y') }} Merah Putih Pers. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/animated.headline.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ticker.js') }}"></script>
    <script src="{{ asset('assets/js/site.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/js/contact.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        $(document).on('click', '.pagination a', function(e) {
            let url = $(this).attr('href');
            if (!url || url === '#' || url.indexOf('javascript:') === 0) return;

            if ($('#berita-container').length > 0) {
                e.preventDefault();
                $.get(url, function(response) {
                    let $responseHtml = $($.parseHTML(response, document, true));
                    let newContent = $responseHtml.find('#berita-container').html();
                    if (newContent) {
                        $('#berita-container').html(newContent);
                        $('html, body').animate({
                            scrollTop: $("#berita-container").offset().top - 100
                        }, 400);
                    } else {
                        window.location.href = url;
                    }
                }).fail(function() {
                    window.location.href = url;
                });
            }
        });

        window.addEventListener("scroll", function() {
            let header = document.querySelector(".header-modern");
            if (!header) return;
            if (window.scrollY > 48) {
                header.style.boxShadow = "0 5px 20px rgba(0,0,0,0.12)";
            } else {
                header.style.boxShadow = "0 2px 10px rgba(0,0,0,0.05)";
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("search-input");
            const resultBox = document.getElementById("search-result");

            let timeout = null;

            input.addEventListener("keyup", function() {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    let query = input.value;

                    if (query.length < 2) {
                        resultBox.style.display = "none";
                        return;
                    }

                    fetch(`/search/autocomplete?q=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            let html = "";

                            if (data.length > 0) {
                                data.forEach(item => {
                                    html += `
                            <a href="/berita/${item.slug}" style="display:flex; align-items:center; padding:8px; gap:10px; text-decoration:none;">
                                
                                <img src="/storage/${item.gambar}" 
                                     style="width:50px; height:50px; object-fit:cover; border-radius:5px;">

                                <span style="color:#000;">${item.judul}</span>
                            </a>
                            `;
                                });
                            } else {
                                html = `<div style="padding:10px;">Tidak ditemukan</div>`;
                            }

                            resultBox.innerHTML = html;
                            resultBox.style.display = "block";
                        })
                        .catch(err => console.log(err));

                }, 300);
            });

            document.addEventListener("click", function(e) {
                if (!input.contains(e.target) && !resultBox.contains(e.target)) {
                    resultBox.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>
