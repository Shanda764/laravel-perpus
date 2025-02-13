<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class -->
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                aria-current="page">
                <i class="nav-icon fas fa-industry"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('kategori') }}" class="nav-link {{ request()->routeIs('kategori') ? 'active' : '' }}"
                aria-current="page">
                <i class="nav-icon fas fa-list"></i>
                <p>Kategori Buku</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('daftar_buku') }}"
                class="nav-link {{ request()->routeIs('daftar_buku') ? 'active' : '' }}" aria-current="page">
                <i class="nav-icon fas fa-book"></i>
                <p>Daftar Buku</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('member') }}" class="nav-link {{ request()->routeIs('member') ? 'active' : '' }}"
                aria-current="page">
                <i class="nav-icon fas fa-users"></i>
                <p>Daftar Member</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bukuMasuk') }}" class="nav-link {{ request()->routeIs('bukuMasuk') ? 'active' : '' }}"
                aria-current="page">
                <i class="nav-icon fas fa-sign-in-alt"></i>
                <p>Buku Masuk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('peminjaman') }}" class="nav-link {{ request()->routeIs('peminjaman') ? 'active' : '' }}"
                aria-current="page">
                <i class="nav-icon fas fa-book-reader"></i>
                <p>Peminjaman Buku</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengembalian') }}"
                class="nav-link {{ request()->routeIs('pengembalian') ? 'active' : '' }}" aria-current="page">
                <i class="nav-icon fas fa-undo"></i>
                <p>Pengembalian Buku</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}"
                aria-current="page">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>Laporan</p>
            </a>
        </li>
    </ul>
</nav>
