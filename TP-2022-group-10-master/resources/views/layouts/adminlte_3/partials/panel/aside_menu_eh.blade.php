<nav class="mt-3">
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu"
        data-accordion="false">
        @php
            // components path
            $group = 'layouts.adminlte_3.components.sidebar.group';
            $item = 'layouts.adminlte_3.components.sidebar.item';
            /**
             * group ($name,$route,$icon)
             * item ($name,$route,$icon='far fa-circle')
             */
        @endphp
        @include($item, [
            'name' => __('aside_menu.dashboard'),
            'route' => 'eh.dashboard.index',
            'icon' => 'fas fa-home',
        ])
        @include($item, [
            'name' => __('Live Stock Data'),
            'route' => 'eh.chart.index',
            'icon' => 'fa fa-chart-line',
        ])

        @include($item, [
            'name' => __('Stock Summary Details'),
            'route' => 'eh.PE.index',
            'icon' => 'fas fa-percentage',
        ])
        @include($item, [
            'name' => __('Trade Tracker / Portfolio'),
            'route' => 'eh.trade.index',
            'icon' => 'fas fa-money-bill-alt',
        ])
        @include($item, [
            'name' => __('Historical Simulator'),
            'route' => 'eh.hs.index',
            'icon' => '	fas fa-history',
        ])
        @include($item, [
            'name' => __('Admin'),
            'route' => 'eh.admin.index',
            'icon' => '	fas fa-chalkboard-teacher',
        ])

    </ul>
</nav>
