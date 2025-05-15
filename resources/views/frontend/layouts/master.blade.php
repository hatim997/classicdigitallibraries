<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>{{ \App\Helpers\Helper::getCompanyName() }} - @yield('title')</title>
    @include('frontend.layouts.meta')
    @include('frontend.layouts.css')
    @yield('css')
    <style>
        .user-dropdown .dropdown-toggle {
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .user-dropdown .dropdown-toggle:hover {
            background-color: #0247bc;
        }

        .user-dropdown .dropdown-menu {
            min-width: 200px;
            border: none;
            border-radius: 0.5rem;
            background-color: #2c2c2c;
        }

        .user-dropdown .dropdown-item {
            color: #ccc;
            font-size: 14px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .user-dropdown .dropdown-item i {
            width: 18px;
        }

        .user-dropdown .dropdown-item:hover {
            background-color: #0247bc;
            color: #fff;
        }

        .active {
            color: #0247bc !important;
        }

        .rating-stars .fa-star {
            color: #ddd;
        }

        .rating-stars .star_on {
            color: #f1c40f;
        }

        .review-count {
            margin-top: 4px;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="site-wrapper" id="top">
        @include('frontend.layouts.header')
        @yield('content')
    </div>
    <!--=================================
    Footer Area
    ===================================== -->
    @include('frontend.layouts.footer')

    <!-- Use Minified Plugins Version For Fast Page Load -->
    @include('frontend.layouts.script')
    @yield('script')
</body>

</html>
