<?php
if (!isset($leftLabel)) {
    $leftLabel = __('common.duallistbox.non-selected');
}
if (!isset($rightLabel)) {
    $rightLabel = __('common.duallistbox.selected');
}
?>

<!-- Bootstrap Duallistbox -->
<script src="{{asset('vendor/adminlte-3.1.0/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<script>
  $(function () {
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox({
        nonSelectedListLabel: '{{$leftLabel}}',
        selectedListLabel: '{{$rightLabel}}',
        infoText: '{{__('common.duallistbox.showing-all')}}',
        infoTextEmpty: '{{__('common.duallistbox.empty-list')}}',
        filterPlaceHolder:'{{__('common.duallistbox.filter')}}',
        filterTextClear: '{{__('common.duallistbox.show-all')}}',
        infoTextFiltered: '{!! __('common.duallistbox.filtered') !!}',
    })
  })
</script>
