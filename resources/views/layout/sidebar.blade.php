<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile not-navigation-link">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image d-flex justify-content-center align-items-center">
                        <i class="mdi mdi-account-circle text-primary" style="font-size:70px;"></i>
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name" style="font-size:24px;">
                            {{ auth()->check() ? auth()->user()->username : 'Guest' }}
                        </p>
                        <div class="dropdown" data-display="static">
                            <a href="#" class="nav-link d-flex user-switch-dropdown-toggler"
                                id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                {{-- <small class="designation text-muted">Admin</small> --}}
                                <span class="status-indicator online"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                                <a class="dropdown-item p-0">
                                    <div class="d-flex border-bottom">
                                        <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                            <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                                        </div>
                                        <div
                                            class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                                            <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                                        </div>
                                        <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                            <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item mt-2"> Manage Accounts </a>
                                <a class="dropdown-item"> Change Password </a>
                                <a class="dropdown-item"> Check Inbox </a>
                                <a class="dropdown-item"> Sign Out </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <button class="btn btn-success btn-block">New Project <i class="mdi mdi-plus"></i> --}}
                </button>
            </div>
        </li>
        <li class="nav-item {{ request()->is('/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('jadwal*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('jadwal.index') }}">
                <i class="menu-icon mdi mdi-table-large"></i>
                <span class="menu-title">CRUD Jadwal</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="menu-icon mdi mdi-table-large"></i>
                <span class="menu-title">CRUD Absensi</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('assessment-categories*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/assessment-categories') }}">
                <i class="menu-icon mdi mdi-format-list-bulleted"></i>
                <span class="menu-title">Kategori Penilaian</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('penilaian/siswa') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/penilaian/siswa') }}">
                <i class="menu-icon mdi mdi-table-large"></i>
                <span class="menu-title">Penilaian</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/laporan') }}">
                <i class="menu-icon mdi mdi-table-large"></i>
                <span class="menu-title">Laporan Penilaian</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('point-rules*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/point-rules') }}">
                <i class="menu-icon mdi mdi-tune"></i>
                <span class="menu-title">Rule Poin</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('points*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('points.index') }}">
                <i class="menu-icon mdi mdi-star"></i>
                <span class="menu-title">Poin Siswa</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('leaderboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('leaderboard') }}">
                <i class="menu-icon mdi mdi-trophy"></i>
                <span class="menu-title">Leaderboard</span>
            </a>
        </li>

        {{-- <li class="nav-item {{ request()->is('marketplace*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('marketplace.index') }}">
                <i class="menu-icon mdi mdi-cart"></i>
                <span class="menu-title">Marketplace Poin</span>
            </a>
        </li> --}}

        <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="menu-icon mdi mdi-account-multiple"></i>
                <span class="menu-title">Manajemen User</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('matapel*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('matapel.index') }}">
                <i class="menu-icon mdi mdi-book-open-page-variant"></i>
                <span class="menu-title">Mata Pelajaran</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('places*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('places.index') }}">
                <i class="menu-icon mdi mdi-map-marker-radius"></i>
                <span class="menu-title">Lokasi Absensi</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kelas*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kelas.index') }}">
                <i class="menu-icon mdi mdi-school"></i>
                <span class="menu-title">Kelas</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('jadwal-sekolah*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('jadwal-sekolah.index') }}">
                <i class="menu-icon mdi mdi-timetable"></i>
                <span class="menu-title">Jadwal Sekolah</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('guru-matapel*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru-matapel.index') }}">
                <i class="menu-icon mdi mdi-book-open-page-variant"></i>
                <span class="menu-title">Guru - Mapel</span>
            </a>
        </li>


        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-success btn-block">
                    Logout <i class="mdi mdi-logout"></i>
                </button>
            </form>
        </li>

    </ul>
</nav>
