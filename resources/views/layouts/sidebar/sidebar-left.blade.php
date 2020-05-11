<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('image/logo_pens_putih.png') }}" alt="Logo PENS" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">Perpustakaan <b>PENS</b></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ (request()->is('buku/*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('buku/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Buku
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/buku/umum" class="nav-link {{ (request()->is('buku/umum') || request()->is('buku/umum/detail/*')) ? 'active' : '' }}">
                                <i class="fa fa-book-open nav-icon"></i>
                                <p>Umum</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/buku/ebook" class="nav-link {{ (request()->is('buku/ebook')) ? 'active' : '' }}">
                                <i class="fa fa-book-open nav-icon"></i>
                                <p>Ebook</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="/buku/jurnal" class="nav-link {{ (request()->is('buku/jurnal')) ? 'active' : '' }}">
                                <i class="fa fa-journal-whills nav-icon"></i>
                                <p>Jurnal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/buku/majalah" class="nav-link {{ (request()->is('buku/majalah')) ? 'active' : '' }}">
                                <i class="fa fa-atlas nav-icon"></i>
                                <p>Majalah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/buku/pa_ta" class="nav-link {{ (request()->is('buku/pa_ta')) ? 'active' : '' }}">
                                <i class="fa fa-journal-whills nav-icon"></i>
                                <p>Proyek Akhir/Tugas Akhir</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (request()->is('peminjaman/*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('peminjaman/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>
                            Peminjaman
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/peminjaman/pesan" class="nav-link {{ (request()->is('peminjaman/pesan')) ? 'active' : '' }}">
                                <i class="fa fa-user-friends nav-icon"></i>
                                <p>Daftar Pemesanan</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/peminjaman/pinjam" class="nav-link {{ (request()->is('peminjaman/pinjam')) ? 'active' : '' }}">
                                <i class="fa fa-user-friends nav-icon"></i>
                                <p>Daftar Peminjaman</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ (request()->is('user/*')) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('user/*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/user/mahasiswa" class="nav-link {{ (request()->is('user/mahasiswa')) ? 'active' : '' }}">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Mahasiswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/user/dosen" class="nav-link {{ (request()->is('user/dosen')) ? 'active' : '' }}">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Dosen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/user/karyawan" class="nav-link {{ (request()->is('user/karyawan')) ? 'active' : '' }}">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Karyawan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/laporan" class="nav-link {{ (request()->is('laporan')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan Peminjaman</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pengaturan" class="nav-link {{ (request()->is('pengaturan')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</aside>
