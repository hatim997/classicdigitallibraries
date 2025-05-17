@extends('layouts.master')

@section('title', __('Course Reviews'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('dashboard.courses.index')}}">{{ __('Courses') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Course Reviews') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Course Reviews List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['update course'])
                    <a href="{{route('dashboard.courses.reviews.create', $course->id)}}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Review') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Review') }}</th>
                            <th>{{ __('Rating') }}</th>
                            <th>{{ __('Created Date') }}</th>
                            @canany(['update course'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->review }}</td>
                                <td>{{ $item->rating }}</td>
                                <td>{{ $item->created_at->format('M d, Y') }}</td>
                                @canany(['update course'])
                                    <td class="d-flex">
                                        <form action="{{ route('dashboard.courses.reviews.delete', $item->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <a href="#" type="submit"
                                                class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Delete Course Review') }}">
                                                <i class="ti ti-trash ti-md"></i>
                                            </a>
                                        </form>
                                        <span class="text-nowrap">
                                            <a href="{{ route('dashboard.courses.reviews.edit', $item->id) }}"
                                                class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Edit Course Review') }}">
                                                <i class="ti ti-edit ti-md"></i>
                                            </a>
                                        </span>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
