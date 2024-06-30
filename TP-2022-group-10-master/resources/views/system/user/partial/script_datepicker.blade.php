
<script>
  $(function () {
    $('#id_dob').datetimepicker({
      format: 'YYYY-MM-DD',
      todayHighlight: true,
      autoclose: true,
      defaultDate: "@if($mode['isModeCreate']){{ date("Y-m-d") }}@else {{ old("dob", isset($u->profile->dob) ? $u->profile->dob : date("Y-m-d")) }} @endif",
    });
  });
</script>