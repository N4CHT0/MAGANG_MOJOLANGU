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
                        <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Data Pengurus
                                    SKTM</span></a>
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
                        <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Data Pengurus
                                    SKTM</span></a>
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
                        <li> <a class="waves-effect waves-dark" href="{{ route('sktms.index') }}"
                                aria-expanded="false"><i class="fa fa-user-circle-o"></i><span class="hide-menu">Data
                                    Pengurus SKTM</span></a>
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
