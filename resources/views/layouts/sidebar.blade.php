@if (auth()->check())
    @if (auth()->user()->role == 'admin')
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Beranda</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Data
                                    Pengurus SKTM</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('users.index') }}"
                                aria-expanded="false"><i class="fa fa-user-circle-o"></i><span class="hide-menu">Data
                                    Pengguna</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out" style="color: red;"></i><span
                                    class="hide-menu">Keluar</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
    @if (auth()->user()->role == 'rt')
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Beranda</span></a>
                        </li>
                        {{-- <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-database"></i><span class="hide-menu">Data
                                    Pengurus SKTM</span></a>
                        </li> --}}
                        <li> <a class="waves-effect waves-dark" href="{{ route('pembangunan.create') }}"
                                aria-expanded="false"><i class="fa fa-database"></i><span class="hide-menu">Buat
                                    Usulan</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('riwayat.pengajuan.rt') }}"
                                aria-expanded="false"><i class="fa fa-history"></i><span class="hide-menu">Riwayat
                                </span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out" style="color: red;"></i><span
                                    class="hide-menu">Keluar</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
    @if (auth()->user()->role == 'rw')
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Beranda</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('pembangunan.verifikasi') }}"
                                aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Data
                                    Usulan</span></a>
                        </li>
                        {{-- <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Data Pengurus
                                    SKTM</span></a>
                        </li> --}}

                        <li> <a class="waves-effect waves-dark" href="{{ route('riwayat.pengajuan.rw') }}"
                                aria-expanded="false"><i class="fa fa-history"></i><span class="hide-menu">Riwayat
                                    Usulan</span></a>
                        </li>

                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out" style="color: red;"></i><span
                                    class="hide-menu">Keluar</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
    @if (auth()->user()->role == 'warga')
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Beranda</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('users.riwayat') }}"
                                aria-expanded="false"><i class="fa fa-history"></i><span
                                    class="hide-menu">Riwayat</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out" style="color: red;"></i><span
                                    class="hide-menu">Keluar</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
    @if (auth()->user()->role == 'lpmd')
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Beranda</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('pembangunan.validasi') }}"
                                aria-expanded="false"><i class="fa fa-check-square-o"></i><span
                                    class="hide-menu">Validasi
                                    Usulan</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('kriteria.index') }}"
                                aria-expanded="false"><i class="fa fa-list-ol"></i><span class="hide-menu">Data
                                    Kriteria</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('kriteria.alternatif') }}"
                                aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Data
                                    Alternatif</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{ route('proses.data') }}"
                                aria-expanded="false">
                                <i class="fa fa-connectdevelop"></i>
                                <span class="hide-menu">Proses Data</span>
                            </a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('perbandingan.index') }}"
                                aria-expanded="false"><i class="fa fa-archive"></i><span class="hide-menu">Data
                                    Perankingan</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out" style="color: red;"></i><span
                                    class="hide-menu">Keluar</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
    @if (auth()->user()->role == 'kelurahan')
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Beranda</span></a>
                        </li>
                        {{-- <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-user-circle-o"></i><span class="hide-menu">Data
                                    Pengurus SKTM</span></a>
                        </li> --}}
                        <li> <a class="waves-effect waves-dark" href="{{ route('perbandingan.index') }}"
                                aria-expanded="false"><i class="fa fa-archive"></i><span
                                    class="hide-menu">Pembangunan</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out" style="color: red;"></i><span
                                    class="hide-menu">Keluar</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
@else
    <!-- Sidebar untuk guest -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li>
                        <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false">
                            <i class="fa fa-home"></i>
                            <span class="hide-menu">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="{{ route('login') }}" aria-expanded="false">
                            <i class="fa fa-sign-in"></i>
                            <span class="hide-menu">Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="{{ route('register') }}" aria-expanded="false">
                            <i class="fa fa-user-plus"></i>
                            <span class="hide-menu">Daftar</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
@endif
