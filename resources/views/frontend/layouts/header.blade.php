<div class="site-header header-2 mb--20 d-none d-lg-block">
    <div class="header-middle pt--10 pb--10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <a href="{{route('frontend.home')}}" class="site-brand">
                        <img src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="" style="max-width: 20% !important;">
                    </a>
                </div>
                <div class="col-lg-5">
                    <div class="header-search-block">
                        <form action="{{ route('frontend.home') }}" method="GET">
                            <input type="text" name="search" placeholder="Search Here">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="main-navigation flex-lg-right">
                        <div class="cart-widget">
                            <!-- Logged-in user profile -->
                            @if (Auth::check())
                                <div class="dropdown user-dropdown">
                                    <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset(Auth::user()->profile->profile_image ?? 'assets/img/default/user.png') }}" alt="User Avatar" class="rounded-circle me-2" width="40" height="40">
                                        <div class="user-info d-none d-md-block">
                                            <span class="fw-semibold">Hi, {{ Auth::user()->name }}</span>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow-sm animate__animated animate__fadeIn" aria-labelledby="userDropdown">
                                        {{-- <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-user me-2"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-cog me-2"></i> Settings
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li> --}}
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom bg-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <nav class="category-nav white-nav">
                        <div>
                            <a href="{{route('frontend.home')}}" class="category-trigger">{{ \App\Helpers\Helper::getCompanyName() }}</a>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-3">
                    @if (Auth::check() && Auth::user()->expiry_date)
                        <div class="header-phone color-white">
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="text">
                                <p>Expiry Date</p>
                                <p class="font-weight-bold number">{{ \Carbon\Carbon::parse(Auth::user()->expiry_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="main-navigation flex-lg-right">
                        <ul class="main-menu menu-right main-menu--white li-last-0">
                            <li class="menu-item">
                                <a href="{{route('frontend.home')}}">Novels</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('frontend.new.episodes')}}">What's New</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('frontend.my-favourites')}}">My Favourites</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-mobile-menu">
    <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
        <div class="container">
            <div class="row align-items-sm-end align-items-center">
                <div class="col-md-10 col-10 d-flex">
                    <a href="{{route('frontend.home')}}" class="site-brand">
                        <img width="40px" src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="">
                    </a>
                    <a href="{{route('frontend.home')}}" style="margin-top: 28px;" class="category-trigger mx-2">{{ \App\Helpers\Helper::getCompanyName() }}</a>
                </div>
                <div class="col-md-2 col-2  order-md-3 text-right">
                    <div class="mobile-header-btns header-top-widget">
                        <ul class="header-links">
                            <li class="sin-link">
                                <a href="javascript:" style="font-size: 20px !important;" class="link-icon hamburgur-icon off-canvas-btn"><i
                                        class="fas fa-bars"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--Off Canvas Navigation Start-->
    <aside class="off-canvas-wrapper">
        <div class="btn-close-off-canvas">
            <i class="fas fa-close"></i>
        </div>
        <div class="off-canvas-inner">
            <!-- search box start -->
            <div class="search-box offcanvas" style="visibility: visible !important;">
                <form action="{{ route('frontend.home') }}" method="GET">
                    <input type="text" name="search" placeholder="Search Here">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <!-- search box end -->
            <!-- mobile menu start -->
            <div class="mobile-navigation">
                <!-- mobile menu navigation start -->
                <nav class="off-canvas-nav">
                    <ul class="mobile-menu main-mobile-menu">
                        <li><a class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}" href="{{route('frontend.home')}}">Novels</a></li>
                        <li><a class="{{ request()->routeIs('frontend.new.episodes') ? 'active' : '' }}" href="{{route('frontend.new.episodes')}}">What's New</a></li>
                        <li><a class="{{ request()->routeIs('frontend.my-favourites') ? 'active' : '' }}" href="{{route('frontend.my-favourites')}}">My Favourites</a></li>
                    </ul>
                </nav>
                <!-- mobile menu navigation end -->
            </div>
        </div>
    </aside>
    <!--Off Canvas Navigation End-->
</div>
<div class="sticky-init fixed-header common-sticky">
    <div class="container d-none d-lg-block">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <a href="{{route('frontend.home')}}" class="">
                    <img width="40px" src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="">
                </a>
                <a href="{{route('frontend.home')}}" class="category-trigger">{{ \App\Helpers\Helper::getCompanyName() }}</a>
            </div>
            <div class="col-lg-8">
                <div class="main-navigation flex-lg-right">
                    <ul class="main-menu menu-right ">
                        <li class="menu-item">
                            <a class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}" href="{{route('frontend.home')}}">Novels</a>
                        </li>
                        <li class="menu-item"><a class="{{ request()->routeIs('frontend.new.episodes') ? 'active' : '' }}" href="{{route('frontend.new.episodes')}}">What's New</a></li>
                        <li class="menu-item"><a class="{{ request()->routeIs('frontend.my-favourites') ? 'active' : '' }}" href="{{route('frontend.my-favourites')}}">My Favourites</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
