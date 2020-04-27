<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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
                                <i class="far fa-user nav-icon"></i>
                                <p>Mahasiswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/user/dosen" class="nav-link {{ (request()->is('user/dosen')) ? 'active' : '' }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Dosen</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/user/pustakawan" class="nav-link {{ (request()->is('user/pustakawan')) ? 'active' : '' }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Pustakawan</p>
                            </a>
                        </li> --}}
                    </ul>
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
