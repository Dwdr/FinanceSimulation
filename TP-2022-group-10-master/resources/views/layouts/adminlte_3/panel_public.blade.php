<!DOCTYPE html>
<!-- TODO check the langauge config if work -->
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.adminlte_3.partials.panel.html_head_meta')
    @include('layouts.adminlte_3.partials.panel.html_head_favicon')
    @include('layouts.adminlte_3.partials.panel.html_head_stylesheet')
</head>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
<style>
    {{-- TODO change font family if needed --}}

    /*html body {*/
    /*    font-family: Helvetica, sans-serif;*/
    /*}*/

    .main-footer {
        margin-left: 0 !important;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
    }

</style>
<body>
<div class="wrapper col-md-8 col-lg-6 m-auto">
    <!-- Content Header (Page header) -->
    @include('layouts.adminlte_3.partials.panel.body_page_header')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid pb-5">
            @section('body_main_content') @show
        </div>
    </section>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <!-- Main Footer -->
    @include('layouts.adminlte_3.partials.panel.body_footer')
</div>
<!-- ./wrapper -->

@include('layouts.adminlte_3.partials.panel.html_end_scripts')
@stack('body_end_scripts')
@include('layouts.adminlte_3.components.form.script_validation')
</body>
</html>
