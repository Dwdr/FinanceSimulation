<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>
        @section('html_title')@show
    </title>
    @include('layouts.adminlte_3.partials.panel.html_head_meta')
    @include('layouts.adminlte_3.partials.panel.html_head_favicon')
    @include('layouts.adminlte_3.partials.panel.html_head_stylesheet')
    @section('html_head_style') @show
    @section('form_style_file_input') @show
    {{-- for livewire --}}
    <livewire:styles />

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body class="hold-transition accent-green text-md">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-grey navbar-dark">
            @include('layouts.adminlte_3.partials.panel.nav_shortcut')
            @include('layouts.adminlte_3.partials.panel.nav_profile')
        </nav>

        <aside class="main-sidebar sidebar-light elevation-4">
            @include('layouts.adminlte_3.partials.panel.aside_brand')
            <div class="sidebar pt-2">
                @include('layouts.adminlte_3.partials.panel.aside_user_panel')
                @include('layouts.adminlte_3.partials.panel.aside_search')
                @include('layouts.adminlte_3.partials.panel.aside_menu_eh')
            </div>
        </aside>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('layouts.adminlte_3.partials.panel.body_page_header')
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('layouts.adminlte_3.components.alert')
                    @section('body_main_content') @show
                </div>
            </section>
        </div>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark bg-white elevation-4">
            @section('control_sidebar')@show
        </aside>
        <!-- Main Footer -->
        @include('layouts.adminlte_3.partials.panel.body_footer')
    </div>
    <!-- ./wrapper -->

    @include('layouts.adminlte_3.partials.panel.html_end_scripts')
    @stack('body_end_scripts')
    @include('layouts.adminlte_3.components.form.script_validation')

    <livewire:scripts />

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

</body>

</html>
