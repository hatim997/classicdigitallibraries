@extends('layouts.master')

@section('title', __('Create Course Review'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('dashboard.courses.index')}}">{{ __('Courses') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{route('dashboard.courses.reviews', $course->id)}}">{{ __('Courses Reviews') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.courses.reviews.store', $course->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-5">
                        <h3>{{ __('Add New Course Review') }}</h3>
                        <div class="mb-4 col-md-12">
                            <label for="review" class="form-label">{{ __('Review') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('review') is-invalid @enderror" type="text" id="review"
                                name="review" required placeholder="{{ __('Enter course review') }}" autofocus
                                value="{{ old('review') }}" />
                            @error('review')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="rating" class="form-label">{{ __('Ratings') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('rating') is-invalid @enderror" type="number" min="1" max="5" id="rating"
                                name="rating" required placeholder="{{ __('Enter rating') }}"
                                value="{{ old('rating') }}" />
                            @error('rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Course Review') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
