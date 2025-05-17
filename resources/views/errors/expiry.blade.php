@extends('layouts.errors.master')

@section('title', 'Account Expired')

@section('css')
@endsection

@section('content')
    <div class="misc-wrapper text-center">
        <h1 class="mb-2 mx-2 text-danger" style="line-height: 6rem; font-size: 6rem">🚫</h1>
        <h4 class="mb-2 mx-2">{{ __('Your Account Has Expired') }}</h4>
        <p class="mb-6 mx-2">{{ __('Your account subscription has expired. To regain access, please renew your subscription or contact our support team if you believe this is an error.') }}</p>
        <div class="d-flex">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger mb-10 mx-4">{{__('Logout')}}</a>
            <a href="#" class="btn btn-primary mb-10">{{__('Contact Support')}}</a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <div class="mt-4">
            <img src="{{ asset('assets/img/illustrations/page-misc-error.png') }}" alt="Account Expired" width="225" class="img-fluid" />
        </div>
    </div>
@endsection

@section('script')
@endsection
