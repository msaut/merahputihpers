<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Admin</div>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('kategori.index')}}">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Kategori</span></a>
                </li>
                <li class="nav-item-active">
                    <a class="nav-link" href="{{route('berita.index')}}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Berita</span></a>
                </li>

                <div class="sb-sidenav-menu-heading mt-3">Static Pages</div>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.static-pages.edit', ['type' => 'terms-of-use']) }}">
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>Terms of Use</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.static-pages.edit', ['type' => 'privacy-policy']) }}">
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>Privacy Policy</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.static-pages.edit', ['type' => 'contact']) }}">
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>Contact</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.index')}}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>User</span></a>
                </li>

                <div class="sb-sidenav-menu-heading mt-3">Premium Member</div>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.members.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Member</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.payments.index') }}">
                        <i class="fas fa-fw fa-credit-card"></i>
                        <span>Verifikasi Pembayaran</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.koran.index') }}">
                        <i class="fas fa-fw fa-file-pdf"></i>
                        <span>Koran PDF</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.subscription-plans.index') }}">
                        <i class="fas fa-fw fa-crown"></i>
                        <span>Paket Langganan</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.payment-methods.index') }}">
                        <i class="fas fa-fw fa-money-bill-wave"></i>
                        <span>Metode Pembayaran</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.rekanans.index') }}">
                        <i class="fas fa-fw fa-handshake"></i>
                        <span>Rekanan</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.banners.index') }}">
                        <i class="fas fa-fw fa-images"></i>
                        <span>Banner / Iklan</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.settings.email') }}">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>Setting Email</span></a>
                </li>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name }}
        </div>
    </nav>
</div>