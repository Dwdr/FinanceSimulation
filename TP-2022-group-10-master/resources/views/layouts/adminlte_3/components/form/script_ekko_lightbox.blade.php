{{--    //data-toggle="lightbox" data-title="{{$a->title}}" data-gallery="gallery"--}}
<script src="{{asset('vendor/adminlte-3.1.0/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
</script>
