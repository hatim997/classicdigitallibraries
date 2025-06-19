@extends('frontend.layouts.master')

@section('title', __('Home'))
@section('description', '')
@section('keywords', '')
@section('author', '')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .nice-select ul {
            height: 150px;
            overflow-y: auto !important;
        }

        .testimonial-image img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
            background-position: center center;
            background-size: cover;
            object-fit: cover;
            transform: rotate(90deg);
        }

        .bg-slider-1 {
            background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);
            /* Soft golden amber */
            color: #333;
            /* Dark grey text for readability */
        }

        .bg-slider-2 {
            background: linear-gradient(135deg, #dfe9f3 0%, #ffffff 100%);
            /* Clean sky to white */
            color: #222;
            /* Slightly darker text */
        }

        /* Section title */
        .section-title h2 {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            color: #2c3e50;
            position: relative;
            margin-bottom: 40px;
        }

        .section-title h2::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #f8b500;
            margin: 15px auto 0;
            border-radius: 2px;
        }

        /* Testimonial Card Container */
        .testimonial-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-6px);
        }

        /* Image Styling */
        .testimonial-image img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: block;
            border: 3px solid #f8b500;
        }

        /* Testimonial Body */
        .testimonial-body {
            text-align: center;
            background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);
        }

        .testimonial-body p {
            font-size: 1rem;
            font-style: italic;
            color: #444;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .client-name {
            font-weight: 600;
            color: #f8b500;
            font-size: 0.95rem;
        }

        .feature-box {
            background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%) !important;
            border: none !important;
        }

        .sb-custom-tab .nav.nav-tabs .nav-item .nav-link.active {
            border-color: transparent;
            color: #0247bc;
            background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%) !important;
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

    <style>
        /* Urdu Pamphlet Modal Styles */
        .urdu-pamphlet-modal .modal-content {
            background: radial-gradient(circle at top right, #fff3e0, #ffe0b2);
            /* Soft cream to dark maroon */
            border-radius: 16px;
            border: 2px solid #ffd700;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            font-family: 'Noto Nastaliq Urdu', serif;
            max-width: 360px;
            margin: auto;
            animation: slideIn 0.6s ease-in-out;
        }

        .urdu-pamphlet-modal .modal-header {
            border-bottom: none;
            padding: 0;
            position: relative;
        }

        .urdu-pamphlet-modal .pamphlet-header-image {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-bottom: 2px solid #ffd700;
        }

        .urdu-pamphlet-modal .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #fff;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .urdu-pamphlet-modal .btn-close i {
            color: #8b0000;
        }

        .urdu-pamphlet-modal .btn-close:hover {
            background: #ffd700;
            transform: scale(1.1);
        }

        .urdu-pamphlet-modal .modal-body {
            padding: 1.4rem;
            text-align: center;
            color: #2c3e50;
        }

        .urdu-pamphlet-modal .modal-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            direction: rtl;
        }

        .urdu-pamphlet-modal .pamphlet-subtitle {
            font-size: 1rem;
            color: #8b0000;
            font-weight: 600;
            margin-bottom: 1rem;
            direction: rtl;
        }

        .urdu-pamphlet-modal .pamphlet-text {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #222;
            direction: rtl;
            margin-bottom: 1.3rem;
        }

        .urdu-pamphlet-modal .pamphlet-benefits {
            list-style: none;
            padding: 0;
            margin-bottom: 1.2rem;
            /* direction: rtl; */
            text-align: right;
        }

        .urdu-pamphlet-modal .pamphlet-benefits li {
            font-size: 0.9rem;
            color: #333;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 0.4rem;
        }

        .urdu-pamphlet-modal .pamphlet-benefits li i {
            color: #8b0000;
            margin-left: 0.5rem;
        }

        .urdu-pamphlet-modal .btn-explore {
            background: #8b0000;
            color: #fff;
            border: 2px solid #ffd700;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 1rem;
            display: inline-block;
            width: 85%;
            text-align: center;
            transition: all 0.3s ease;
            font-family: 'Noto Nastaliq Urdu', serif;
        }

        .urdu-pamphlet-modal .btn-explore:hover {
            background: #ffd700;
            color: #8b0000;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .urdu-pamphlet-modal .modal-footer {
            justify-content: center;
            padding: 0 1rem 1rem;
            border-top: none;
        }

        .urdu-pamphlet-modal .dismiss-link {
            font-size: 0.85rem;
            color: #2c3e50;
            text-decoration: none;
        }

        .urdu-pamphlet-modal .dismiss-link:hover {
            color: #8b0000;
            text-decoration: underline;
        }

        /* Modal Background Pattern */
        .urdu-pamphlet-modal .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('frontAssets/image/bg-images/pamphlet.jpg') }}') repeat;
            opacity: 0.03;
            z-index: 0;
        }

        .urdu-pamphlet-modal .modal-content>* {
            position: relative;
            z-index: 1;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Tweaks */
        @media (max-width: 576px) {
            .urdu-pamphlet-modal .modal-content {
                max-width: 95%;
            }

            .urdu-pamphlet-modal .modal-title {
                font-size: 1.4rem;
            }

            .urdu-pamphlet-modal .pamphlet-text {
                font-size: 0.85rem;
            }

            .urdu-pamphlet-modal .pamphlet-benefits li {
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Urdu Pamphlet Modal -->
    <div class="modal fade urdu-pamphlet-modal" id="urduPamphletModal" tabindex="-1" aria-labelledby="urduPamphletModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('frontAssets/image/bg-images/pamphlet.jpg') }}" alt="Urdu Novel Header"
                        class="pamphlet-header-image">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="pamphlet-content">
                        <h5 class="modal-title" id="urduPamphletModalLabel">کلاسک ڈیجیٹل لائبریریز</h5>
                        <p class="pamphlet-subtitle">پہلا مہینہ مفت!</p>
                        <p class="pamphlet-text">
                            لفظوں کی دنیا میں کھو جائیں۔ ہر کہانی آپ کے دل کو چھو لے گی — عشق، جذبہ، اور سسپنس سے بھرپور۔
                        </p>
                        <ul class="pamphlet-benefits">
                            <li><i class="fas fa-book-open mx-2"></i> دلکش پلاٹس</li>
                            <li><i class="fas fa-heart mx-2"></i> جذباتی رنگ</li>
                            <li><i class="fas fa-star mx-2"></i> نئے لکھاری، نئی کہانیاں</li>
                        </ul>
                        <a href="{{ route('frontend.novels') }}" class="btn btn-explore">ابھی مطالعہ کریں</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="dismiss-link" data-bs-dismiss="modal">بعد میں دیکھیں</a>
                </div>
            </div>
        </div>
    </div>


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
            <div class="single-slide bg-shade-whisper bg-slider-1">
                <div class="container">
                    <div class="home-content text-center text-sm-left position-relative">
                        <div class="hero-partial-image image-right">
                            <img style="width: 60% !important;"
                                src="{{ asset('frontAssets/image/bg-images/slider-01.png') }}" alt="">
                        </div>
                        <div class="row g-0">
                            <div class="col-xl-6 col-md-6 col-sm-7">
                                <div class="home-content-inner content-left-side text-start">
                                    <h1>Anaya Ahmed</h1>
                                    <h2>Jahan Mohabbat Lafzon Mein Dhalti Hai</h2>
                                    <a href="{{ route('frontend.novels') }}" class="btn btn-outlined--primary">
                                        Read Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slide bg-ghost-white bg-slider-2">
                <div class="container">
                    <div class="home-content text-center text-sm-left position-relative">
                        <div class="hero-partial-image image-left">
                            <img style="width: 60% !important;"
                                src="{{ asset('frontAssets/image/bg-images/slider-02.png') }}" alt="">
                        </div>
                        <div class="row align-items-center justify-content-start justify-content-md-end">
                            <div class="col-lg-6 col-xl-7 col-md-6 col-sm-7">
                                <div class="home-content-inner content-right-side text-start">
                                    <h1>Ayat Noor</h1>
                                    <h2>Har Safha Ik Nai Duniya, Ik Nai Kahani</h2>
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
                                                                <a
                                                                    href="{{ route('frontend.novel.details', $course->id) }}">
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
                                                                <a
                                                                    href="{{ route('frontend.novel.details', $course->id) }}">
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
            <div class="sb-slick-slider testimonial-slider"
                data-slick-setting='{
            "autoplay": true,
            "autoplaySpeed": 8000,
            "slidesToShow":3,
            "dots":true
            }'
                data-slick-responsive='[
                {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                {"breakpoint":992, "settings": {"slidesToShow": 1} },
                {"breakpoint":768, "settings": {"slidesToShow": 1} },
                {"breakpoint":490, "settings": {"slidesToShow": 1} }
            ]'>

                <div class="single-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="{{ asset('frontAssets/image/testimonials/testimonial-01.jpg') }}" alt="">
                        </div>
                        <div class="testimonial-body">
                            <article>
                                <h2 class="sr-only">Testimonial Article</h2>
                                <p>Yaar such mein, itne maze ka content kahin aur nahi milta. Urdu novels
                                    zabardast hai!</p>
                                <span class="d-block client-name">Fatima Ali – Lahore</span>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="single-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="{{ asset('frontAssets/image/testimonials/testimonial-04.jpg') }}" alt="">
                        </div>
                        <div class="testimonial-body">
                            <article>
                                <h2 class="sr-only">Testimonial Article</h2>
                                <p>Main roz raat ko aik novel parhta hoon is website se. Har kahani dil ko choo jati hai!
                                </p>
                                <span class="d-block client-name">Ali Raza – Karachi</span>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="single-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="{{ asset('frontAssets/image/testimonials/testimonial-02.jpg') }}" alt="">
                        </div>
                        <div class="testimonial-body">
                            <article>
                                <h2 class="sr-only">Testimonial Article</h2>
                                <p>Bachpan se novels ka craze tha, lekin is site ne to meri reading life hi next level pe le
                                    gayi hai!</p>
                                <span class="d-block client-name">Sadia Malik – Islamabad</span>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="single-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="{{ asset('frontAssets/image/testimonials/testimonial-05.jpg') }}" alt="">
                        </div>
                        <div class="testimonial-body">
                            <article>
                                <h2 class="sr-only">Testimonial Article</h2>
                                <p>Storylines itni realistic hoti hain ke lagta hai jaise sab meri aankhon ke samne ho raha
                                    ho.</p>
                                <span class="d-block client-name">Hassan Javed – Faisalabad</span>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="single-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="{{ asset('frontAssets/image/testimonials/testimonial-03.jpg') }}" alt="">
                        </div>
                        <div class="testimonial-body">
                            <article>
                                <h2 class="sr-only">Testimonial Article</h2>
                                <p>Na sirf stories best hain, balkay website ka design bhi bohot user-friendly hai. Great
                                    job team!</p>
                                <span class="d-block client-name">Nimra Khan – Multan</span>
                            </article>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // if (!localStorage.getItem('urduPamphletModalShown')) {
            var urduPamphletModal = new bootstrap.Modal(document.getElementById('urduPamphletModal'), {
                backdrop: 'static',
                keyboard: false
            });
            urduPamphletModal.show();
            localStorage.setItem('urduPamphletModalShown', 'true');
            // }
        });
    </script>

@endsection
