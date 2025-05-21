@extends('frontend.layouts.master')

@section('title', __('My Favourites'))
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
            background: #f8fafc;
            position: relative;
            height: 92%;
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
    <section class="breadcrumb-section">
        {{-- <h2 class="sr-only">Site Breadcrumb</h2> --}}
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Favourites</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            @if (isset($userFavourites) && count($userFavourites) > 0)
                <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
                    @foreach ($userFavourites as $favourite)
                        <div class="col-lg-3 col-sm-6">
                            <div class="product-card">
                                <div class="product-grid-content">
                                    {{-- <div class="product-header">
                                        <h3><a href="{{route('frontend.novel.details', $favourite->course->id)}}">{{ $favourite->course->name }}</a></h3>
                                    </div> --}}
                                    <div class="product-card--body">
                                        <div class="card-image">
                                            <img style="height: 220px; width: 100%;"
                                                src="{{ asset('courses/' . $favourite->course->image) }}" alt="">
                                            <div class="hover-contents">
                                                <a href="{{route('frontend.novel.details', $favourite->course->id)}}" class="hover-image">
                                                    <img style="height: 220px; width: 100%;"
                                                        src="{{ asset('courses/' . $favourite->course->image) }}" alt="">
                                                </a>
                                                <div class="hover-btns">
                                                    <a href="{{route('frontend.add.favourite', $favourite->course->id)}}" class="single-btn">
                                                        <i class="fas fa-heart text-warning"></i>
                                                    </a>
                                                    <a href="{{route('frontend.novel.details', $favourite->course->id)}}"
                                                        class="single-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $averageRating = number_format(
                                                $favourite->course->reviews->map(fn($review) => $review->rating !== null ? (float)$review->rating : 0)->avg(),
                                                1
                                            );
                                            $reviewCount = $favourite->course->reviews->count();
                                            $averageRating = number_format($averageRating, 1); // e.g., 4.3
                                        @endphp

                                        <div class="rating-summary">
                                            <h3><a href="{{route('frontend.novel.details', $favourite->course->id)}}">{{ $favourite->course->name }}</a></h3>
                                            <div class="rating-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="fas fa-star {{ $i <= round($averageRating) ? 'star_on' : '' }}"></span>
                                                @endfor
                                            </div>
                                            @if ($reviewCount > 0)
                                                <div class="review-count text-muted small">
                                                    ({{ $averageRating }} average / {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})
                                                </div>
                                            @else
                                                <div class="review-count text-muted small">
                                                    (No reviews yet)
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination Block -->
                <div class="row pt--30">
                    <div class="col-md-12">
                        <div class="pagination-block">
                            <ul class="pagination-btns flex-center">
                                @if ($userFavourites->onFirstPage())
                                    <li><a href="" class="single-btn prev-btn "><i class="fas fa-chevron-left"></i> </a>
                                    </li>
                                @else
                                    <li><a href="{{ $userFavourites->previousPageUrl() }}" class="single-btn prev-btn "><i
                                                class="fas fa-chevron-left"></i> </a>
                                    </li>
                                @endif

                                @foreach ($userFavourites->getUrlRange(1, $userFavourites->lastPage()) as $page => $url)
                                    <li class="{{ $page == $userFavourites->currentPage() ? 'active' : '' }}"><a
                                            href="{{ $url }}" class="single-btn">{{ $page }}</a></li>
                                @endforeach

                                @if ($userFavourites->hasMorePages())
                                    <li><a href="{{ $userFavourites->nextPageUrl() }}" class="single-btn next-btn"><i
                                                class="fas fa-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li><a href="" class="single-btn next-btn"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <p>No Favourites</p>
            @endif
        </div>
    </main>

@endsection

@section('script')
    <script></script>
@endsection
