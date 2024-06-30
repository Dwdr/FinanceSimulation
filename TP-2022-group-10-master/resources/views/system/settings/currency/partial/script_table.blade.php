
<script>
        $().ready(function() {
            $('#dataTable').DataTable( {
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "order": [[ 0, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": 2 },
                ]
            } );
        } );
</script>