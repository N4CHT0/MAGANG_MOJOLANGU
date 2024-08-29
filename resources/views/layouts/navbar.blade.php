<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/home">
                <!-- Logo icon --><b>
                    <img src="{{ asset('admin-master/assets/images/LOGO_MOJOLANGU.png') }}"
                        style="width: 50px;height: 50px;" alt="homepage" class="dark-logo" />
                    <img src="{{ asset('admin-master/assets/images/logo-light-icon.png') }}" alt="homepage"
                        class="light-logo" />
                </b>
                <!-- Logo text --><span>
                    <img src="{{ asset('admin-master/assets/images/LOGO_APP.jpg') }}" alt="homepage" class="dark-logo"
                        style="width: 100px;height: 20px;" />
                    <img src="{{ asset('admin-master/assets/images/logo-light-text.png') }}" class="light-logo"
                        alt="homepage" /></span>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i
                            class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item hidden-xs-down search-box">
                    <a class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)">
                        <i class="fa fa-search"></i>
                    </a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search & enter">
                        <a class="srh-btn"><i class="fa fa-times"></i></a>
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                @auth
                    <!-- Jika pengguna sudah autentikasi -->
                    <li class="nav-item dropdown u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic d-flex align-items-center"
                            href="#" id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img src="{{ asset('admin-master/assets/images/users/1.jpg') }}" alt="user"
                                class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;" />
                            <span class="d-none d-md-inline ms-2">{{ Auth::user()->nama_lengkap }}</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
