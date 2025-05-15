@extends('frontend.layouts.master')

@section('title', __('Whats New'))
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
                        <li class="breadcrumb-item active">What's New</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
                @if (isset($biodatas) && count($biodatas) > 0)
                    @foreach ($biodatas as $episode)
                        <div class="col-lg-3 col-sm-6">
                            <div class="product-card">
                                <div class="product-grid-content">
                                    <div class="product-header">
                                        <a href="{{route('frontend.novel.details', $episode->course->id)}}" class="author">
                                            {{ $episode->course->name }}
                                        </a>
                                        <h3><a href="{{ route('frontend.read.novel', $episode->id) }}">{{ $episode->episode ?? $episode->namaSiswa }}</a></h3>
                                    </div>
                                    <div class="product-card--body">
                                        <div class="card-image">
                                            <img style="height: 220px; width: 100%;"
                                                src="{{ asset('courses/' . $episode->course->image) }}" alt="">
                                            <div class="hover-contents">
                                                <a href="{{ route('frontend.read.novel', $episode->id) }}" class="hover-image">
                                                    <img style="height: 220px; width: 100%;"
                                                        src="{{ asset('courses/' . $episode->course->image) }}" alt="">
                                                </a>
                                                <div class="hover-btns">
                                                    <a href="{{ route('frontend.read.novel', $episode->id) }}"
                                                        class="single-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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
    </main>

@endsection

@section('script')
    <script></script>
@endsection
