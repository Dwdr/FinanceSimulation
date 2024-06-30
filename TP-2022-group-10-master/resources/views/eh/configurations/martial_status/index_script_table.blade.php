<script>
  $().ready(function() {
      $('#dataTable').DataTable( {
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          "language": {
              "url": "{{asset('lang/datatables/'.App::getLocale().'.json')}}"
          },
          "deferRender": true,
          "responsive": true
      } );
  } );
</script>
