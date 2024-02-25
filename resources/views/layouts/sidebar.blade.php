<aside class="bg-white shadow sidebar-left border-right" id="leftSidebar" data-simplebar>
    <a href="#" class="mt-3 ml-2 btn collapseSidebar toggle-btn d-lg-none text-muted" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">

        {{-- Logo --}}
        <div class="mb-4 w-100 d-flex">
            <a class="mx-auto mt-2 text-center navbar-brand flex-fill" href="/">
                <img src="{{ asset('logo/'.getLogo()) }}" class="mb-3 img-fluid" alt="" style="max-height: 80px">
            </a>
        </div>

        <ul class="mb-2 navbar-nav flex-fill w-100">
            {{-- Dashboard Menu --}}
            <li class="nav-item w-100 {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fe fe-activity fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>

            {{-- Home Menu --}}
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('guest') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Home</span>
                </a>
            </li>
        </ul>

        @if (Auth()->user()->role == "Customer")
        {{-- Histori Menu --}}
        <ul class="mb-2 navbar-nav flex-fill w-100" style="margin-top: -5px">
            <li class="nav-item w-100 {{ request()->is('histori-transaksi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('histori-transaksi') }}">
                    <i class="fe fe-rotate-ccw fe-16"></i>
                    <span class="ml-3 item-text">Histori Transaksi</span>
                </a>
            </li>
        </ul>
        @endif

        @if (Auth()->user()->role == "Admin" || Auth()->user()->role == "Staff")
            <p class="mt-4 mb-1 text-muted nav-heading">
                <span>Data</span>
            </p>
            <ul class="mb-2 navbar-nav flex-fill w-100">

                {{-- Item Menu --}}
                <li class="nav-item w-100 {{ request()->is('produk') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('produk.index') }}">
                        <i class="fe fe-package fe-16"></i>
                        <span class="ml-3 item-text">Produk</span>
                    </a>
                </li>

                {{-- Bahan Baku Menu --}}
                <li class="nav-item w-100 {{ request()->is('bahan-baku') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('bahan.index') }}">
                        <i class="fe fe-codepen fe-16"></i>
                        <span class="ml-3 item-text">Bahan Baku</span>
                    </a>
                </li>

                {{-- Penjualan Menu --}}
                <li class="nav-item dropdown {{ request()->is('transaksi') ? 'active' : '' }}">
                    <a href="#tansaksi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link collapsed">
                        <i class="fe fe-shopping-cart fe-16"></i>
                        <span class="ml-3 item-text">Transaksi</span>
                    </a>
                    <ul class="pl-4 list-unstyled w-100 collapse" id="tansaksi" style="">
                        <a class="pl-3 nav-link" href="{{ route('transaksi.index') }}"><span class="ml-1">List Transaksi</span></a>
                        <a class="pl-3 nav-link" href="{{ route('transaksi.create') }}"><span class="ml-1">Transaksi Baru</span></a>
                    </ul>
                </li>

                @if (Auth()->user()->role == "Admin")
                {{-- User Menu --}}
                <li class="nav-item w-100 {{ request()->is('user') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fe fe-user fe-16"></i>
                        <span class="ml-3 item-text">User</span>
                    </a>
                </li>
                @endif
            </ul>
        @endif

        @if (Auth()->user()->role == "Admin")
            <p class="mt-4 mb-1 text-muted nav-heading">
                <span>Rekap</span>
            </p>
            <ul class="mb-2 navbar-nav flex-fill w-100">

                {{-- Laporan Produk --}}
                <li class="nav-item w-100 {{ request()->is('laporan-produk') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('laporanProduk.index') }}">
                        <i class="fe fe-book-open fe-16"></i>
                        <span class="ml-3 item-text">Laporan Produk</span>
                    </a>
                </li>

                {{-- Laporan Bahan Baku --}}
                <li class="nav-item w-100 {{ request()->is('laporan-bahan-baku') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('laporanBahanBaku.index') }}">
                        <i class="fe fe-book-open fe-16"></i>
                        <span class="ml-3 item-text">Laporan Bahan Baku</span>
                    </a>
                </li>

                {{-- Laporan Penjualan --}}
                <li class="nav-item w-100 {{ request()->is('laporan-transaksi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('laporanTransaksi.index') }}">
                        <i class="fe fe-book-open fe-16"></i>
                        <span class="ml-3 item-text">Laporan Transaksi</span>
                    </a>
                </li>
            </ul>
        @endif
    </nav>
</aside>
