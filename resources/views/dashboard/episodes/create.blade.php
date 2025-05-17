@extends('layouts.master')

@section('title', __('Create Episode'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.episodes.index') }}">{{ __('Episodes') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.episodes.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-5">
                        <h3>{{ __('Add Sub Course') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}" autofocus value="{{old('name')}}"/>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="episode" class="form-label">{{ __('Episode Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('episode') is-invalid @enderror" type="text" id="episode"
                                name="episode" required placeholder="{{ __('Enter episode name') }}" autofocus value="{{old('episode')}}"/>
                            @error('episode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="course_id">{{ __('Course') }} <span
                                class="text-danger">*</span></label>
                            <select id="course_id" name="course_id" class="select2 form-select @error('course_id') is-invalid @enderror" required>
                                <option value="" selected disabled>{{ __('Select Course') }}</option>
                                @if (isset($courses) && count($courses) > 0)
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ $course->id == old('course_id') ? 'selected' : '' }}>{{ $course->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('course_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="sub_course_id">{{ __('Sub Course') }} <span
                                class="text-danger">*</span></label>
                            <select id="sub_course_id" name="sub_course_id" class="select2 form-select @error('sub_course_id') is-invalid @enderror" required>
                                <option value="" selected disabled>{{ __('Select Course') }}</option>
                                @if (isset($subcourses) && count($subcourses) > 0)
                                    @foreach ($subcourses as $subcourse)
                                        <option value="{{ $subcourse->id }}"
                                            {{ $subcourse->id == old('sub_course_id') ? 'selected' : '' }}>{{ $subcourse->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('sub_course_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="folder" class="form-label">{{ __('Link') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('folder') is-invalid @enderror" type="text" id="folder"
                                name="folder" required placeholder="{{ __('Enter link') }}" autofocus value="{{old('folder')}}"/>
                            @error('folder')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="switch switch-square">
                                <label for="is_new" class="switch-label">{{ __('New') }} <br> <small>Is this new?</small></label>
                                <input type="checkbox" class="switch-input @error('is_new') is-invalid @enderror" id="is_new"
                                    name="is_new" {{ old('is_new') ? 'checked' : '' }}>
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                            @error('is_new')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Episode') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <!-- Page JS -->
    <script>
        $(document).ready(function() {
            //
        });
    </script>


@endsection
