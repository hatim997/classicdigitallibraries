@extends('frontend.layouts.master')

@section('title', __('Contact Us'))
@section('description', '')
@section('keywords', '')
@section('author', '')

@section('css')
@endsection

@section('content')
    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- contact area Start -->
    <main class="contact_area inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact_form">
                        <h3 class="ct_title">Send Us a Message</h3>
                        <form action="{{ route('frontend.contact.submit') }}" method="post" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Your Name <span class="text-danger required">*</span></label>
                                        <input type="text" id="con_name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Your Email <span class="text-danger required">*</span></label>
                                        <input type="email" id="con_email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Your Message</label>
                                        <textarea id="con_message" name="message" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="6Le5wpErAAAAAOglbOZ07KLKcaa_8bwiQs5Mf4wO">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        @error('g-recaptcha-response')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-btn">
                                        <button type="submit" value="submit" id="submit" class="btn btn-black w-100"
                                            name="submit">Send</button>
                                    </div>
                                    <div class="form__output"></div>
                                </div>
                            </div>
                        </form>
                        <div class="form-output">
                            <p class="form-messege"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <iframe width="100%" height="500" style="border:0" loading="lazy" allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q=Karachi,%20Pakistan&output=embed">
                    </iframe>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
<!-- reCAPTCHA Script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
