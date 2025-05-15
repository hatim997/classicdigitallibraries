@extends('frontend.layouts.master')

@section('title', __('Novel Episodes'))
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
@endsection
@section('content')
    <section class="breadcrumb-section">
        {{-- <h2 class="sr-only">Site Breadcrumb</h2> --}}
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Novels</a></li>
                        <li class="breadcrumb-item active">Episodes</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row  mb--60">
                <div class="col-lg-5 mb--30">
                    <!-- Product Details Slider Big Image-->
                    <div class="product-details-slider sb-slick-slider arrow-type-two"
                        data-slick-setting='{
                        "slidesToShow": 1,
                        "arrows": false,
                        "fade": true,
                        "draggable": false,
                        "swipe": false,
                        "asNavFor": ".product-slider-nav"
                        }'>
                        <div class="single-slide">
                            <img src="{{ asset('courses/' . $subcourse->course->image) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-info pl-lg--30">
                        <h3 class="product-title">{{ $subcourse->name }}</h3>
                
                        <ul class="list-unstyled">
                            <li>
                                <strong>Released at:</strong>
                                <span class="list-value"> {{ $subcourse->created_at->format('M d, Y') }}</span>
                            </li>
                            <li class="mt-3"><strong>Episodes:</strong></li>
                
                            @if (isset($biodatas) && count($biodatas) > 0)
                                @foreach ($biodatas as $index => $episode)
                                    <li class="mt-2">
                                        <i class="fas fa-play-circle mr-2 text-primary"></i>
                                        <a href="{{ route('frontend.read.novel', $episode->id) }}" target="_blank" class="list-value font-weight-bold">
                                            {{ $episode->episode ?? $episode->namaSiswa }}
                                        </a>
                
                                        @if ($episode->is_new == 1)
                                            <span class="badge bg-danger ml-2">New</span>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li class="mt-2 text-muted">No episodes available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--=================================
                RELATED PRODUCTS BOOKS
            ===================================== -->
        <section class="">
            <div class="container">
                <div class="section-title section-title--bordered">
                    <h2>RELATED Novels</h2>
                </div>
                <div class="product-slider sb-slick-slider slider-border-single-row"
                    data-slick-setting='{
                        "autoplay": true,
                        "autoplaySpeed": 8000,
                        "slidesToShow": 4,
                        "dots":true
                    }'
                    data-slick-responsive='[
                        {"breakpoint":1200, "settings": {"slidesToShow": 4} },
                        {"breakpoint":992, "settings": {"slidesToShow": 3} },
                        {"breakpoint":768, "settings": {"slidesToShow": 2} },
                        {"breakpoint":480, "settings": {"slidesToShow": 1} }
                    ]'>
                    @if (isset($relatedCourses) && count($relatedCourses) > 0)
                        @foreach ($relatedCourses as $relatedCourse)
                            <div class="single-slide">
                                <div class="product-card">
                                    <div class="product-header" style="height: 50px;">
                                        <h3><a href="{{route('frontend.novel.details', $relatedCourse->id)}}">{{ $relatedCourse->name }}</a></h3>
                                    </div>
                                    <div class="product-card--body">
                                        <div class="card-image">
                                            <img style="width: 100%; height: 150px;" src="{{ asset('courses/' . $relatedCourse->image) }}" alt="">
                                            <div class="hover-contents">
                                                <a href="{{route('frontend.novel.details', $relatedCourse->id)}}" class="hover-image">
                                                    <img style="width: 100%; height: 150px;" src="{{ asset('courses/' . $relatedCourse->image) }}" alt="">
                                                </a>
                                                <div class="hover-btns">
                                                    <a href="wishlist.html" class="single-btn">
                                                        <i class="fas fa-heart"></i>
                                                    </a>
                                                    <a href="{{route('frontend.novel.details', $relatedCourse->id)}}"
                                                        class="single-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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
        </section>
    </main>

@endsection

@section('script')
    <script></script>
@endsection
