@extends('frontend.layouts.master')

@section('title', __('Home'))
@section('description', '')
@section('keywords', '')
@section('author', '')

@section('css')
    <style>
        .nice-select ul {
            height: 150px;
            overflow-y: auto !important;
        }
    </style>
    <style>
        .product-card {
            border: 1px solid #e0e0e0;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            position: relative;
            height: 92%;
        }
        .product-card-body {
            height: 380px;
            background-color: #f8fafc;
        }
        .product-card-body2 {
            height: 325px;
            background-color: #f8fafc;
        }

        .product-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
            border-color: #c0c0c0;
        }

        .card-image {
            position: relative;
            overflow: hidden;
            border-radius: 15px 15px 0 0;
            border-bottom: 3px solid #eee;
        }

        .card-image img {
            transition: transform 0.3s ease;
            object-fit: cover;
        }

        .hover-contents {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: all 0.3s ease;
            /* background: rgba(255, 255, 255, 0.9); */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card:hover .hover-contents {
            opacity: 1;
        }

        .hover-btns {
            display: flex;
            gap: 15px;
            background: transparent !important;
        }

        .single-btn {
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 2px solid #e5e7eb;
            background-color: #fff;
            padding: 10px;
        }

        .single-btn:hover {
            background: #eeee;
            color: white;
            transform: scale(1.1);
            border-color: transparent;
        }

        .rating-summary {
            padding: 1.2rem;
            background: #f8fafc;
            border-top: 2px solid #f1f5f9;
        }

        .rating-summary h3 a {
            color: #2d3748;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }
    </style>
@endsection

@section('content')
    <!--=================================
                Hero Area
            ===================================== -->
    <section class="hero-area hero-slider-1">
        <div class="sb-slick-slider"
            data-slick-setting='{
                            "autoplay": true,
                            "fade": true,
                            "autoplaySpeed": 3000,
                            "speed": 3000,
                            "slidesToShow": 1,
                            "dots":true
                            }'>
            <div class="single-slide bg-shade-whisper  ">
                <div class="container">
                    <div class="home-content text-center text-sm-left position-relative">
                        <div class="hero-partial-image image-right">
                            <img src="{{ asset('frontAssets/image/bg-images/home-slider-2-ai.png') }}" alt="">
                        </div>
                        <div class="row g-0">
                            <div class="col-xl-6 col-md-6 col-sm-7">
                                <div class="home-content-inner content-left-side text-start">
                                    <h1>H.G. Wells<br>
                                        De Vengeance</h1>
                                    <h2>Cover Up Front Of Books and Leave Summary</h2>
                                    <a href="{{ route('frontend.novels') }}" class="btn btn-outlined--primary">
                                        Read Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slide bg-ghost-white">
                <div class="container">
                    <div class="home-content text-center text-sm-left position-relative">
                        <div class="hero-partial-image image-left">
                            <img src="{{ asset('frontAssets/image/bg-images/home-slider-1-ai.png') }}" alt="">
                        </div>
                        <div class="row align-items-center justify-content-start justify-content-md-end">
                            <div class="col-lg-6 col-xl-7 col-md-6 col-sm-7">
                                <div class="home-content-inner content-right-side text-start">
                                    <h1>J.D. Kurtness <br>
                                        De Vengeance</h1>
                                    <h2>Cover Up Front Of Books and Leave Summary</h2>
                                    <a href="{{ route('frontend.novels') }}" class="btn btn-outlined--primary">
                                        Read Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
                Home Features Section
            ===================================== -->
    <section class="mb--30">
        <div class="container">
            <div class="row">
                <!-- Instant Reading -->
                <div class="col-xl-3 col-md-6 mt--30">
                    <div class="feature-box h-100">
                        <div class="icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="text">
                            <h5>Instant Reading</h5>
                            <p>Read novels instantly</p>
                        </div>
                    </div>
                </div>

                <!-- Latest Releases -->
                <div class="col-xl-3 col-md-6 mt--30">
                    <div class="feature-box h-100">
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="text">
                            <h5>Latest Releases</h5>
                            <p>Explore newest novels</p>
                        </div>
                    </div>
                </div>

                <!-- Readers Community -->
                <div class="col-xl-3 col-md-6 mt--30">
                    <div class="feature-box h-100">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="text">
                            <h5>Readers Community</h5>
                            <p>Connect literature lovers</p>
                        </div>
                    </div>
                </div>

                <!-- 24/7 Access -->
                <div class="col-xl-3 col-md-6 mt--30">
                    <div class="feature-box h-100">
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="text">
                            <h5>24/7 Access</h5>
                            <p>Read anytime, anywhere</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                Promotion Section One
            ===================================== -->
    <section class="section-margin">
        <h2 class="sr-only">Promotion Section</h2>
        <div class="container">
            <div class="row space-db--30">
                <div class="col-lg-6 col-md-6 mb--30">
                    <a href="" class="promo-image promo-overlay">
                        <img src="{{ asset('frontAssets/image/bg-images/promo-banner-with-text.jpg') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 mb--30">
                    <a href="" class="promo-image promo-overlay">
                        <img src="{{ asset('frontAssets/image/bg-images/promo-banner-with-text-2.jpg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
                Home Slider Tab
            ===================================== -->
    <section class="section-padding">
        <h2 class="sr-only">Home Tab Slider Section</h2>
        <div class="container">
            <div class="sb-custom-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="shop-tab" data-bs-toggle="tab" href="#shop" role="tab"
                            aria-controls="shop" aria-selected="true">
                            Popular Novels
                        </a>
                        <span class="arrow-icon"></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="men-tab" data-bs-toggle="tab" href="#men" role="tab"
                            aria-controls="men" aria-selected="true">
                            New Arrivals
                        </a>
                        <span class="arrow-icon"></span>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane show active" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                        <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
                            @if (isset($popularNovels) && count($popularNovels) > 0)
                                @foreach ($popularNovels as $course)
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="single-slide">
                                            <div class="product-card">
                                                <div class="product-grid-content">
                                                    <div class="product-card-body">
                                                        <!-- Card Image -->
                                                        <div class="card-image">
                                                            <img style="height: 220px; width: 100%; object-fit: cover;"
                                                                src="{{ asset('courses/' . $course->image) }}"
                                                                alt="{{ $course->name }}">
                                                            <div class="hover-contents">
                                                                <a href="{{ route('frontend.novel.details', $course->id) }}"
                                                                    class="hover-image">
                                                                    <img style="height: 220px; width: 100%; object-fit: cover;"
                                                                        src="{{ asset('courses/' . $course->image) }}"
                                                                        alt="{{ $course->name }}">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <!-- Ratings and Title -->
                                                        @php
                                                            $validRatings = $course->reviews
                                                                ->filter(fn($r) => $r->rating !== null)
                                                                ->pluck('rating')
                                                                ->map(fn($r) => (float) $r);
                                                            $averageRating = $validRatings->avg() ?? 0;
                                                            $averageRatingFormatted = number_format($averageRating, 1);
                                                            $reviewCount = $course->reviews
                                                                ->whereNotNull('review')
                                                                ->count();
                                                        @endphp

                                                        <div class="rating-summary">
                                                            <h3 class="novel-title">
                                                                <a href="{{ route('frontend.novel.details', $course->id) }}">
                                                                    {{ $course->name }}
                                                                </a>
                                                            </h3>
                                                            <div class="rating-stars">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <span
                                                                        class="fas fa-star {{ $i <= round($averageRating) ? 'star_on' : '' }}"></span>
                                                                @endfor
                                                            </div>
                                                            <div class="review-count text-muted small">
                                                                @if ($reviewCount > 0)
                                                                    ({{ $averageRatingFormatted }} average /
                                                                    {{ $reviewCount }}
                                                                    {{ Str::plural('review', $reviewCount) }})
                                                                @else
                                                                    (No reviews yet)
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane" id="men" role="tabpanel" aria-labelledby="men-tab">
                        <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
                            @if (isset($newNovels) && count($newNovels) > 0)
                                @foreach ($newNovels as $course)
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="single-slide">
                                            <div class="product-card">
                                                <div class="product-grid-content">
                                                    <div class="product-card-body2">
                                                        <!-- Card Image -->
                                                        <div class="card-image">
                                                            <img style="height: 220px; width: 100%; object-fit: cover;"
                                                                src="{{ asset('courses/' . $course->image) }}"
                                                                alt="{{ $course->name }}">
                                                            <div class="hover-contents">
                                                                <a href="{{ route('frontend.novel.details', $course->id) }}"
                                                                    class="hover-image">
                                                                    <img style="height: 220px; width: 100%; object-fit: cover;"
                                                                        src="{{ asset('courses/' . $course->image) }}"
                                                                        alt="{{ $course->name }}">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="rating-summary">
                                                            <h3 class="novel-title">
                                                                <a href="{{ route('frontend.novel.details', $course->id) }}">
                                                                    {{ $course->name }}
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
        CLIENT TESTIMONIALS
    ===================================== -->
        <section class="section-margin">
            <div class="container">
                <div class="section-title section-title--bordered mb-lg--60">
                    <h2>CLIENT TESTIMONIALS</h2>
                </div>
                <div class="sb-slick-slider testimonial-slider" data-slick-setting='{
                    "autoplay": true,
                    "autoplaySpeed": 8000,
                    "slidesToShow":3,
                    "dots":true
                    }' data-slick-responsive='[
                        {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                        {"breakpoint":992, "settings": {"slidesToShow": 1} },
                        {"breakpoint":768, "settings": {"slidesToShow": 1} },
                        {"breakpoint":490, "settings": {"slidesToShow": 1} }
                    ]'>
                    <div class="single-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="{{asset('frontAssets/image/others/client-1.png')}}" alt="">
                            </div>
                            <div class="testimonial-body">
                                <article>
                                    <h2 class="sr-only">Testimonial Article</h2>
                                    <p>version This is Photoshops of Lorem Ipsum. Proin gravida nibh vel velit.Lorem
                                        ipsum dolor sit amet, consectetur
                                        adipiscing elit. In molestie augue magna. Pell..</p>
                                    <span class="d-block client-name">Rebecka Filson</span>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="single-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="{{asset('frontAssets/image/others/client-2.png')}}" alt="">
                            </div>
                            <div class="testimonial-body">
                                <article>
                                    <h2 class="sr-only">Testimonial Article</h2>
                                    <p>In molestie augue magna.This is Photoshops version of Lorem Ipsum. Proin gravida
                                        nibh vel velit.Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit. Pell..</p>
                                    <span class="d-block client-name">Rebecka Filson</span>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="single-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="{{asset('frontAssets/image/others/client-3.png')}}" alt="">
                            </div>
                            <div class="testimonial-body">
                                <article>
                                    <h2 class="sr-only">Testimonial Article</h2>
                                    <p>Lorem Ipsum This is Photoshops version of . Proin gravida nibh vel velit.Lorem
                                        ipsum dolor sit amet, consectetur
                                        adipiscing elit. In molestie augue magna. Pell..</p>
                                    <span class="d-block client-name">Rebecka Filson</span>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="single-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="{{asset('frontAssets/image/others/client-4.png')}}" alt="">
                            </div>
                            <div class="testimonial-body">
                                <article>
                                    <h2 class="sr-only">Testimonial Article</h2>
                                    <p>elit. In molestie This is Photoshops version of Lorem Ipsum. Proin gravida nibh
                                        vel velit.Lorem ipsum dolor sit amet, consectetur
                                        adipiscing augue magna. Pell..</p>
                                    <span class="d-block client-name">Rebecka Filson</span>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="single-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="{{asset('frontAssets/image/others/client-5.png')}}" alt="">
                            </div>
                            <div class="testimonial-body">
                                <article>
                                    <h2 class="sr-only">Testimonial Article</h2>
                                    <p>Pell Photoshops version of Lorem Ipsum. Proin gravida nibh vel velit.Lorem ipsum
                                        dolor sit amet, consectetur
                                        adipiscing elit. In molestie augue magna. This is..</p>
                                    <span class="d-block client-name">Rebecka Filson</span>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section('script')
    <script></script>
@endsection
