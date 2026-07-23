<!doctype html>
<html class="no-js" lang="zxx">
<style>
.footer-box {
    transition: 0.3s;
}
.footer-box:hover {
    transform: translateY(-3px);
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
/* RESET HEADER */
.header-modern {
    width: 100%;
    font-family: 'Poppins', sans-serif;
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
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 999;
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
@media (max-width: 768px) {
    .nav-menu {
        display: none;
    }

    .search-box {
        display: none;
    }

    .header-flex {
        justify-content: space-between;
    }
}
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MerahPutihpers.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    {{-- Open Graph / Social Share Meta --}}
    @hasSection('og_meta')
        @yield('og_meta')
    @else
        <meta property="og:title" content="MerahPutihPers.com - Berita Terkini" />
        <meta property="og:description" content="Portal berita faktual dan bermanfaat untuk masyarakat." />
        <meta property="og:image" content="{{ asset('assets/img/logo/logo.png') }}" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="MerahPutihPers" />
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
        <div class="container-fluid d-flex justify-content-between">
            <div class="date">
                {{ date('l, d M Y') }}
            </div>
            <div class="social">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
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
                <ul>
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
        <!-- Footer Start -->
        <div class="footer-area footer-padding fix">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-5 col-lg-5 col-md-7 col-sm-12">
                        <div class="single-footer-caption">
                            <div class="footer-logo">
                                <a href="{{ url('/') }}"><img src="{{asset('assets/img/logo/logo.png')}}" alt="" width="200px"></a>
                            </div>
                            <div class="footer-tittle">
                                <div class="footer-pera">
                                    <p>Merah Putih Pers Hadir untuk Memberikan Penerangan Terhadap Berita-berita yang baik,faktual,dan bermanfaat bagi masyarakat,kami menjaga etika dalam jurnalistik demi kebenaran dan kepentingan publik.</p>
                                </div>
                        </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-footer-caption mt-60">
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
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-footer-caption mt-60">
                            <div class="footer-tittle">
                                <h4>Newsletter</h4>
                                <p>Heaven fruitful doesn't over les idays appear creeping</p>
                                <div class="footer-form">
                                    <div id="mc_embed_signup">
                                        <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative mail_part">
                                            <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address" class="placeholder hide-on-focus" onfocus="this.placeholder = ''" onblur="this.placeholder = ' Email Address '">
                                            <div class="form-icon">
                                                <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm"><img src="assets/img/logo/form-iocn.png" alt=""></button>
                                            </div>
                                            <div class="mt-10 info"></div>
                                        </form>
                                    </div>
                            </div>
                    </div>
            </div>
        <!-- Footer Bottom -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-lg-6">
                            <div class="footer-copy-right">
                                <p>Copyright &copy; {{ date('Y') }} Merah Putih Pers, All Rights Reserved</p>
                            </div>
                    </div>
            </div>
        <!-- Footer End -->
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
</body>
</html>
