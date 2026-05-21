<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Mini POS</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard (Semua role bisa akses) -->
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span>
        </a>
    </li>

    <!-- MENU UNTUK ALL ROLE (Kasir, Kepala Toko, Admin) -->
    <li class="nav-item">
        <a class="nav-link" href="/transaksi">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Transaksi</span>
        </a>
    </li>

    <!-- MENU UNTUK KEPALA TOKO & ADMIN -->
    @if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'kepala_toko'))
    <li class="nav-item">
        <a class="nav-link" href="/DataProduk">
            <i class="fas fa-fw fa-box"></i>
            <span>Data Produk</span>
        </a>
    </li>
    @endif

    <!-- MENU UNTUK ADMIN SAJA -->
    @if (auth()->check() && auth()->user()->role === 'admin')
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Manajemen
    </div>
    <li class="nav-item">
        <a class="nav-link" href="/users">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/roles">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan Role</span>
        </a>
    </li>
    @endif

    <!-- About (Semua role bisa akses) -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>About</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout Button di Sidebar -->
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="nav-link btn btn-link" style="color: #fff; width: 100%; text-align: left;">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>

    <!-- Toggle -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>