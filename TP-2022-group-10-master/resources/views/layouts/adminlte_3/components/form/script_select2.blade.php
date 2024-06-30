<!-- Select2 -->
<script src="{{asset('vendor/adminlte-3.1.0/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
            width: '100%',
            theme: 'bootstrap4',
            placeholder: "{{__('common.please-select')}}",
        });
    })
</script>
