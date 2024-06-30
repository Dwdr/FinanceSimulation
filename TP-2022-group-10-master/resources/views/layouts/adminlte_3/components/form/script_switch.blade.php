<!-- Bootstrap Switch -->
<script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script>
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });
</script>
