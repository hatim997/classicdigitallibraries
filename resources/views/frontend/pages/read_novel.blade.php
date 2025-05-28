{{-- <style>
    .embed-container {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .full-embed {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
</style> --}}
<div class="embed-container">
    @if ($file->is_new == 1)
        <embed loading="lazy" src="{{ $file->folder }}" frameborder="0"
            style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px"
            height="100%" width="100%">
    @else
        <embed loading="lazy" src="{{ url('/') . '/' . $file->folder . '/index.html' }}" frameborder="0"
            style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px"
            height="100%" width="100%">
    @endif
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script>
    $(document).ready(function() {
        $("img").on("contextmenu", function() {
            return false;
        });
    });
</script>
