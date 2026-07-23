<!doctype html>
<html class="no-js" lang="zxx">
<style>
.footer-area {
    background: #f8f9fa;
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

/* biar sejajar */
.footer-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-col {
    flex: 1;
    min-width: 250px;
}

/* footer bottom */
.footer-bottom-area {
    background: #111;
    color: #fff;
    padding: 15px 0;
}

.footer-copy-right p {
    margin: 0;
    font-size: 14px;
}
/* RESET HEADER & STICKY */
.header-modern {
    width: 100%;
    font-family: 'Poppins', sans-serif;
    position: sticky;
    top: -48px;
    z-index: 9999;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: box-shadow 0.3s ease;
    overflow: visible !important;
}

/* TOP BAR */
.top-bar {
    background: #111;
    color: #ccc;
    font-size: 13px;
    padding: 8px 0;
}

.top-bar .social a {
    color: #ccc;
    margin-left: 15px;
    transition: 0.3s;
}

.top-bar .social a:hover {
    color: #fff;
}

/* MAIN HEADER */
.main-header {
    background: #fff;
    transition: all 0.3s ease-in-out;
}
body {
    padding-top: 0;
}

/* FLEX */
.header-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 40px;
}

/* LOGO */
.logo img {
    height: 50px;
}

/* MENU */
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

/* HOVER UNDERLINE */
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

/* SEARCH */
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

/* FULL WIDTH FIX */
.container-fluid {
    padding-left: 50px;
    padding-right: 50px;
}
    .header-flex {
        justify-content: space-between;
    }
@media (max-width: 768px) {
    .nav-menu {
        display: none;
    }

    .search-box {
        display: none;
    }
}
/* TOP BAR HITAM */
.top-bar {
    background: #000;
    color: #fff;
    padding: 10px 40px;
    font-size: 14px;
}

/* SOCIAL ICON */
.top-social {
    display: flex;
    align-items: center;
    gap: 15px;
}

.top-social a img {
    width: 28px; /* BESAR */
    height: 28px;
    object-fit: contain;
    transition: 0.3s;
}

/* HOVER EFFECT */
.top-social a:hover img {
    transform: scale(1.2);
}
.top-social a:hover img {
    transform: scale(1.2);
    filter: drop-shadow(0 0 5px rgba(255,255,255,0.5));
}
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@hasSection('title')@yield('title')@else MerahPutihpers.com - Berita Terkini @endif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    {{-- Open Graph / Social Share Meta --}}
    @hasSection('og_meta')
        @yield('og_meta')
    @else
        {{-- Default OG untuk halaman selain artikel --}}
        @php $defaultOgImage = asset('assets/img/logo/logo.png'); @endphp
        <meta name="description" content="Portal berita faktual dan bermanfaat untuk masyarakat." />
        <meta property="og:title" content="MerahPutihPers.com - Berita Terkini" />
        <meta property="og:description" content="Portal berita faktual dan bermanfaat untuk masyarakat." />
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
    @if($adEnable && !empty($adClient))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adClient }}" crossorigin="anonymous"></script>
    @endif

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
</head>
<body>
   <header class="header-modern">
    <!-- TOP BAR -->
    <div class="top-bar">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- KIRI (Tanggal) -->
        <div class="date">
            {{ date('l, d M Y') }}
        </div>

        <!-- KANAN (Social Besar) -->
        <div class="top-social">

            <a href="https://web.facebook.com/profile.php?id=61591466745591" target="_blank">
                <img src="{{ asset('assets/img/news/icon-fb.png') }}" alt="fb">
            </a>

            <a href="https://www.instagram.com/merahputihpers/" target="_blank">
                <img src="{{ asset('assets/img/news/icon-ins.png') }}" alt="ig">
            </a>

            <a href="https://www.tiktok.com/@merahputihpers" target="_blank">
                <img src="{{ asset('assets/img/news/icon-ttk.png') }}" alt="tiktok">
            </a>

            <a href="https://youtube.com/@merahputihpers" target="_blank">
                <img src="{{ asset('assets/img/news/icon-yo.png') }}" alt="yt">
            </a>

        </div>
    </div>
</div>

    <!-- MAIN HEADER -->
    <div class="main-header">
        <div class="container-fluid header-flex">
            
            <!-- LOGO -->
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo">
                </a>
            </div>

            <!-- MENU -->
            <nav class="nav-menu">
                <ul id="navigation">
                    <li><a href="/">Home</a></li>
                    @php $kategori = \App\Models\Kategori::all(); @endphp
                    @foreach ($kategori as $kategori)
                        <li>
                            <a href="{{ route('web.kategori', $kategori->id) }}">
                                {{ $kategori->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- SEARCH -->
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari berita...">
            </div>

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

                <!-- LOGO + DESKRIPSI -->
                <div class="footer-col">
                    <div class="footer-logo mb-3">
                        <a href="{{ url('/') }}">
                            <img src="{{asset('assets/img/logo/logo.png')}}" alt="">
                        </a>
                    </div>
                    <div class="footer-pera">
                        <p>
                            Merah Putih Pers hadir untuk memberikan penerangan terhadap berita yang baik, faktual,
                            dan bermanfaat bagi masyarakat. Kami menjaga etika jurnalistik demi kebenaran publik.
                        </p>
                    </div>
                </div>

                <!-- TERMS -->
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
                            <li><a href="https://suararakyat.info" target="_blank">suararakyat.info</a></li>
                            <li><a href="https://mitrapolisi.com" target="_blank">mitrapolisi.com</a></li>
                        </ul>
                    </div>
                </div>

                <!-- NEWSLETTER -->
                <div class="footer-col">
                    <div class="footer-box p-4 rounded shadow-sm bg-white">
                        <h5 class="fw-bold mb-3">Newsletter</h5>
                        <p>Subscribe untuk update berita terbaru</p>

                        <form class="subscribe_form">
                            <input type="email" placeholder="Email Address" class="form-control mb-2">
                            <button class="btn btn-danger w-100">Subscribe</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER BOTTOM -->
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
            e.preventDefault();
            let url = $(this).attr('href');
            if (!url) return;
            $.get(url, function(response) {
                let newContent = $(response).find('#berita-container').html();
                $('#berita-container').html(newContent);
                $('html, body').animate({ scrollTop: $("#berita-container").offset().top - 100 }, 400);
            }).fail(function() { alert('Gagal load pagination'); });
        });
    </script>
    <script>
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
</body>
</html>
