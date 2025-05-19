@extends('frontend.layouts.master')

@section('title', __('Novel Details'))
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
                        <li class="breadcrumb-item active">Details</li>
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
                            <img src="{{ asset('courses/' . $course->image) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-info pl-lg--30 ">
                        <h3 class="product-title">{{ $course->name }}</h3>
                        <ul class="list-unstyled">
                            <li>Released at: <span class="list-value"> {{ $course->created_at->format('M d, Y') }}</span>
                            </li>
                            <li>Sub Courses</li>
                            @if (isset($course->subcourses) && count($course->subcourses) > 0)
                                @foreach ($course->subcourses as $index => $subcourse)
                                    <li>Sub-Course {{ $index + 1 }}: <a
                                            href="{{ route('frontend.subcourse.details', $subcourse->id) }}"
                                            class="list-value font-weight-bold"> {{ $subcourse->name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="rating-widget">
                            {{-- @php
                                // $averageRating = $course->reviews->avg('rating');
                                $averageRating = number_format(
                                    $course->reviews->map(fn($review) => $review->rating !== null ? (float)$review->rating : 0)->avg(),
                                    1
                                );
                                $reviewCount = $course->reviews->count();
                                $averageRating = number_format($averageRating, 1);
                            @endphp
                            <div class="rating-block">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="fas fa-star {{ $i <= round($averageRating) ? 'star_on' : '' }}"></span>
                                @endfor
                            </div>
                            <div class="review-widget">
                                @if ($reviewCount > 0)
                                    <a href="">({{ $averageRating }} average / {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</a> <span>|</span>
                                @else
                                    <div class="review-count">
                                        (No reviews yet)
                                    </div>
                                @endif
                            </div> --}}
                            @php
                                // Only non-null ratings for average calculation
                                $validRatings = $course->reviews
                                    ->filter(fn($review) => $review->rating !== null)
                                    ->pluck('rating')
                                    ->map(fn($r) => (float) $r);
                                $averageRating = $validRatings->avg() ?? 0;
                                $averageRatingFormatted = number_format($averageRating, 1);

                                // Total review count including null ratings
                                $reviewCount = $course->reviews->count();
                            @endphp

                            <div class="rating-block">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="fas fa-star {{ $i <= round($averageRating) ? 'star_on' : '' }}"></span>
                                @endfor
                            </div>

                            <div class="review-widget">
                                @if ($reviewCount > 0)
                                    <a href="">
                                        ({{ $averageRatingFormatted }} average / {{ $reviewCount }}
                                        {{ Str::plural('review', $reviewCount) }})
                                    </a>
                                    <span>|</span>
                                @else
                                    <div class="review-count">
                                        (No reviews yet)
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="compare-wishlist-row">
                            @php
                                $isFavourite =
                                    Auth::check() && Auth::user()->userFavourites->contains('course_id', $course->id);
                            @endphp
                            <a href="{{ route('frontend.add.favourite', $course->id) }}" class="add-link"><i
                                    class="fas fa-heart {{ $isFavourite ? 'text-warning' : '' }}"></i>{{ $isFavourite ? 'Remove From Favourites' : 'Add to Favourites' }}</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="sb-custom-tab review-tab section-padding">
                <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#tab-1" role="tab"
                            aria-controls="tab-1" aria-selected="true">
                            REVIEWS ({{ count($course->reviews) }})
                        </a>
                    </li>
                </ul>
                <div class="tab-content space-db--20" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
                        <div class="review-wrapper">
                            <h2 class="title-lg mb--20">{{ count($course->reviews) }} REVIEWS FOR {{ $course->name }}</h2>
                            @if (count($course->reviews) > 0)
                                @foreach ($course->reviews as $review)
                                    <div class="review-comment mb--20">
                                        <div class="avatar">
                                            <img src="{{ isset($review->user->profile) ? asset($review->user->profile->profile_image ?? 'assets/img/default/user.png') : asset('assets/img/default/user.png') }}" alt="">
                                        </div>
                                        <div class="text">
                                            <div class="rating-block mb--15">
                                                @if ($review->rating != null)
                                                    @php
                                                        $userRating = $review->rating ?? 0;
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="fas fa-star {{ $i <= round($userRating) ? 'star_on' : '' }}"></span>
                                                    @endfor
                                                @else
                                                    <span>Comment</span>
                                                @endif
                                            </div>
                                            <h6 class="author">{{$review->user->name}} – <span class="font-weight-400">{{ $review->created_at->format('M d, Y') }}</span>
                                            </h6>
                                            <p>{{$review->review}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
                            <div class="rating-row pt-2">
                                <p class="d-block">Your Rating</p>
                                <form action="{{ route('frontend.reviews.store', $course->id) }}" method="POST" class="mt--15 site-form">
                                    @csrf
                                    <span class="rating-widget-block d-flex justify-content-end">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                                            <label for="star{{ $i }}"></label>
                                        @endfor
                                    </span>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="message">Comment</label>
                                                <textarea name="review" id="message" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="submit-btn">
                                                <button type="submit" class="btn btn-black">Post Comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="sb-custom-tab review-tab section-padding">
                <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="ratings-tab" data-bs-toggle="tab" href="#ratings" role="tab"
                            aria-controls="ratings" aria-selected="true">
                            RATINGS ({{ $course->reviews->whereNotNull('rating')->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab"
                            aria-controls="reviews" aria-selected="false">
                            REVIEWS ({{ $course->reviews->whereNull('rating')->whereNotNull('review')->count() }})
                        </a>
                    </li>
                </ul>

                <div class="tab-content space-db--20" id="myTabContent">
                    {{-- RATINGS Tab --}}
                    <div class="tab-pane fade show active" id="ratings" role="tabpanel" aria-labelledby="ratings-tab">
                        <div class="review-wrapper">
                            <h2 class="title-lg mb--20">
                                {{ $course->reviews->whereNotNull('rating')->count() }} RATINGS FOR {{ $course->name }}
                            </h2>

                            @php
                                $ratings = $course->reviews->whereNotNull('rating')->sortByDesc('created_at')->values();
                            @endphp

                            @foreach ($ratings as $index => $review)
                                <div class="review-comment mb--20 rating-review"
                                    style="{{ $index >= 5 ? 'display:none;' : '' }}">
                                    <div class="avatar">
                                        <img src="{{ isset($review->user->profile) ? asset($review->user->profile->profile_image ?? 'assets/img/default/user.png') : asset('assets/img/default/user.png') }}"
                                            alt="">
                                    </div>
                                    <div class="text">
                                        <div class="rating-block mb--15">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span
                                                    class="fas fa-star {{ $i <= round($review->rating) ? 'star_on' : '' }}"></span>
                                            @endfor
                                        </div>
                                        <h6 class="author">{{ $review->user->name }} – <span
                                                class="font-weight-400">{{ $review->created_at->format('M d, Y') }}</span>
                                        </h6>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if ($ratings->count() > 5)
                                <div class="text-center mt-3">
                                    <button class="btn btn-sm btn-primary" id="loadMoreRatings">View More</button>
                                </div>
                            @endif

                            {{-- ADD A REVIEW SECTION --}}
                            <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
                            <div class="rating-row pt-2">
                                <p class="d-block">Your Rating</p>
                                <form action="{{ route('frontend.reviews.store', $course->id) }}" method="POST"
                                    class="mt--15 site-form">
                                    @csrf
                                    <span class="rating-widget-block d-flex justify-content-end">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}"
                                                value="{{ $i }}">
                                            <label for="star{{ $i }}"></label>
                                        @endfor
                                    </span>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="message">Comment</label>
                                                <textarea name="review" id="message" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="submit-btn">
                                                <button type="submit" class="btn btn-black">Post Comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- REVIEWS Tab (Comments only) --}}
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="review-wrapper">
                            <h2 class="title-lg mb--20">
                                {{ $course->reviews->whereNull('rating')->whereNotNull('review')->count() }} REVIEWS FOR {{ $course->name }}
                            </h2>

                            @php
                                $comments = $course->reviews->whereNull('rating')->whereNotNull('review')->sortByDesc('created_at')->values();
                            @endphp

                            @foreach ($comments as $index => $review)
                                <div class="review-comment mb--20 comment-review"
                                    style="{{ $index >= 5 ? 'display:none;' : '' }}">
                                    <div class="avatar">
                                        <img src="{{ isset($review->user->profile) ? asset($review->user->profile->profile_image ?? 'assets/img/default/user.png') : asset('assets/img/default/user.png') }}"
                                            alt="">
                                    </div>
                                    <div class="text">
                                        <span class="text-muted small">Comment Only</span>
                                        <h6 class="author">{{ $review->user->name }} – <span
                                                class="font-weight-400">{{ $review->created_at->format('M d, Y') }}</span>
                                        </h6>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if ($comments->count() > 5)
                                <div class="text-center mt-3">
                                    <button class="btn btn-sm btn-primary" id="loadMoreComments">View More</button>
                                </div>
                            @endif

                            {{-- ADD A REVIEW SECTION --}}
                            <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
                            <div class="rating-row pt-2">
                                <p class="d-block">Your Rating</p>
                                <form action="{{ route('frontend.reviews.store', $course->id) }}" method="POST"
                                    class="mt--15 site-form">
                                    @csrf
                                    <span class="rating-widget-block d-flex justify-content-end">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}"
                                                value="{{ $i }}">
                                            <label for="star{{ $i }}"></label>
                                        @endfor
                                    </span>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="message">Comment</label>
                                                <textarea name="review" id="message" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="submit-btn">
                                                <button type="submit" class="btn btn-black">Post Comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                        <h3><a
                                                href="{{ route('frontend.novel.details', $relatedCourse->id) }}">{{ $relatedCourse->name }}</a>
                                        </h3>
                                    </div>
                                    <div class="product-card--body">
                                        <div class="card-image">
                                            <img style="width: 100%; height: 150px;"
                                                src="{{ asset('courses/' . $relatedCourse->image) }}" alt="">
                                            <div class="hover-contents">
                                                <a href="{{ route('frontend.novel.details', $relatedCourse->id) }}"
                                                    class="hover-image">
                                                    <img style="width: 100%; height: 150px;"
                                                        src="{{ asset('courses/' . $relatedCourse->image) }}"
                                                        alt="">
                                                </a>
                                                <div class="hover-btns">
                                                    <a href="wishlist.html" class="single-btn">
                                                        <i class="fas fa-heart"></i>
                                                    </a>
                                                    <a href="{{ route('frontend.novel.details', $relatedCourse->id) }}"
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
    <script>
        let ratingIndex = 5;
        let commentIndex = 5;

        document.getElementById('loadMoreRatings')?.addEventListener('click', function() {
            let hiddenRatings = document.querySelectorAll('.rating-review[style*="display:none"]');
            for (let i = 0; i < 5 && i < hiddenRatings.length; i++) {
                hiddenRatings[i].style.display = '';
            }
            ratingIndex += 5;
            if (document.querySelectorAll('.rating-review[style*="display:none"]').length === 0) {
                this.style.display = 'none';
            }
        });

        document.getElementById('loadMoreComments')?.addEventListener('click', function() {
            let hiddenComments = document.querySelectorAll('.comment-review[style*="display:none"]');
            for (let i = 0; i < 5 && i < hiddenComments.length; i++) {
                hiddenComments[i].style.display = '';
            }
            commentIndex += 5;
            if (document.querySelectorAll('.comment-review[style*="display:none"]').length === 0) {
                this.style.display = 'none';
            }
        });
    </script>

@endsection
