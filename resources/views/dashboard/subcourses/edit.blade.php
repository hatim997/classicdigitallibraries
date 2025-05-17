@extends('layouts.master')

@section('title', __('Edit Sub Course'))

@section('css')
@endsection


@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('dashboard.subcourses.index') }}">{{ __('Sub Courses') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection
{{-- @dd($service) --}}
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.subcourses.update', $subcourse->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row p-5">
                        <h3>{{ __('Edit Sub Course') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}" autofocus value="{{old('name', $subcourse->name)}}"/>
                            @error('name')
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
                                            {{ $course->id == old('course_id', $subcourse->course_id) ? 'selected' : '' }}>{{ $course->name }}
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
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Update Sub Course') }}</button>
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
