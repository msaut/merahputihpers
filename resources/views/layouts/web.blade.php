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
    <header>
        <div class="header-area">
            <div class="main-header">
                <div class="header-top black-bg d-none d-md-block">
                    <div class="container">
                        <div class="col-xl-12">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="header-info-left">
                                    <ul>
                                        <li><img src="{{asset('assets/img/icon/header_icon1.png')}}" alt="">{{ date('Y M d D') }}</li>
                                    </ul>
                                </div>
                                <div class="header-info-right">
                                    <ul class="header-social">
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    </ul>
                                </div>
                        </div>
                </div>
                <div class="header-mid d-none d-md-block">
                    <div class="container">
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="logo">
                                    <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt="" width="200px" loading="lazy"></a>
                                </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <div class="header-banner f-right">
                                    <img src="{{asset('assets/img/hero/header_card.png')}}" alt="" loading="lazy">
                                </div>
                        </div>
                </div>
                <div class="header-bottom header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                                <div class="main-menu d-none d-md-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            @php $kategori = \App\Models\Kategori::all(); @endphp
                                            @foreach ($kategori as $kategori)
                                            <li class="news-item">
                                                <a href="{{ route('web.kategori', $kategori->id) }}" class="nav-item nav-link js-whats-new-filter">{{ $kategori->nama }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            <div class="col-xl-2 col-lg-2 col-md-4">
                                <div class="header-right-btn f-right d-none d-lg-block">
                                    <i class="fas fa-search special-tag"></i>
                                    <div class="search-box">
                                        <form action="#">
                                            <input type="text" placeholder="Search">
                                        </form>
                                    </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-md-none"></div>
                        </div>
                </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-area footer-padding fix">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-5 col-lg-5 col-md-7 col-sm-12">
                        <div class="single-footer-caption">
                            <div class="single-footer-caption">
                                <div class="footer-logo">
                                    <a href="{{ url('/') }}"><img src="{{asset('assets/img/logo/logo.png')}}" alt="" width="200px"></a>
                                </div>
                                <div class="footer-tittle">
                                    <div class="footer-pera">
                                        <p>Merah Putih Pers Hadir untuk Memberikan Penerangan Terhadap Berita-berita yang baik,faktual,dan bermanfaat bagi masyarakat,kami menjaga etika dalam jurnalistik demi kebenaran dan kepentingan publik.</p>
                                    </div>
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
