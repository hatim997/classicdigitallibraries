@extends('layouts.mails.master')

@section('title', 'New Contact Message Received')

@section('css')
@endsection

@section('content')
    <p><strong>New contact form submission received.</strong></p>

    <div class="contact-details">
        <h3>Sender Details:</h3>
        <p><strong>Name:</strong> {{ $email_data['name'] }}</p>
        <p><strong>Email:</strong> {{ $email_data['email'] }}</p>
    </div>

    @if(!empty($email_data['message']))
        <div class="message-content mt-3">
            <h3>Message:</h3>
            <p>{{ $email_data['message'] }}</p>
        </div>
    @else
        <p><em>No message was included in the form.</em></p>
    @endif

    <p class="mt-4">Please respond accordingly or follow up if necessary.</p>
@endsection

@section('script')
@endsection
