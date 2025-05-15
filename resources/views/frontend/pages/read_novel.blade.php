@if ($file->is_new == 1)
    <embed loading="lazy" src="{{ $file->folder }}" frameborder="0"
        style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px"
        height="100%" width="100%">
@else
    <embed loading="lazy" src="{{ url('/') . '/' . $file->folder . '/index.html' }}" frameborder="0"
        style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px"
        height="100%" width="100%">
@endif
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script>
    $(document).ready(function() {
        $("img").on("contextmenu", function() {
            return false;
        });
    });
</script>
