<header class="navigation fixed-top">
    <div class="container">
        <!-- main nav -->
        <nav class="navbar navbar-expand-lg navbar-light px-0">
            <!-- logo -->
            <a class="navbar-brand logo" href="index.html">
                <img loading="lazy" class="logo-default" src="{{ asset('landing-master/theme/images/LOGO_APP.png') }}"
                    alt="logo" />
                <img loading="lazy" class="logo-white"
                    src="{{ asset('landing-master/theme/images/LOGO_APP_WHITE.png') }}" alt="logo" />
            </a>
            <!-- /logo -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navigation">
                <ul class="navbar-nav ml-auto text-center">
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#!" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Beranda <i class="tf-ion-chevron-down"></i>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="service.html">Services</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="portfolio.html">Portfolio</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="team.html">Team</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="pricing.html">Pricing</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#!" id="navbarDropdown02" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pages <i class="tf-ion-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown02">
                            <li><a class="dropdown-item" href="404.html">404 Page</a></li>
                            <li><a class="dropdown-item" href="blog.html">Blog Page</a></li>
                            <li><a class="dropdown-item" href="single-post.html">Blog Single Page</a></li>

                            <li class="dropdown dropdown-submenu dropleft">
                                <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0201" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu <i
                                        class="tf-ion-chevron-down"></i></a>

                                <ul class="dropdown-menu" aria-labelledby="dropdown0201">
                                    <li><a class="dropdown-item" href="index.html">Submenu 01</a></li>
                                    <li><a class="dropdown-item" href="index.html">Submenu 02</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('daftar-masuk') }}">Masuk/Daftar</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /main nav -->
    </div>
</header>
