<!-- Core JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="{{ asset('frontAssets/js/plugins.js') }}"></script>
<script src="{{ asset('frontAssets/js/ajax-mail.js') }}"></script>
<!-- jQuery (required for Toastr) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="{{ asset('frontAssets/js/custom.js') }}"></script>
@yield('script')


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    toastr.options = {
        "closeButton": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "2000"
    };
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('message'))
        toastr.info("{{ session('message') }}");
    @endif

    @if ($errors->any())
        toastr.error("{{ $errors->first() }}");
    @endif
</script>
