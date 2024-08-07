<script>
    $().ready(function() {
        $('#movementDataTable').DataTable( {
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "url": "{{asset('lang/datatables/'.App::getLocale().'.json')}}"
            },
            "order": [[ 0, "desc" ]],
            "deferRender": true,
            "responsive": true
        } );

        $('#packageDataTable').DataTable( {
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "url": "{{asset('lang/datatables/'.App::getLocale().'.json')}}"
            },
            "order": [[ 0, "desc" ]],
            "deferRender": true,
            "responsive": true
        } );
    } );
</script>
