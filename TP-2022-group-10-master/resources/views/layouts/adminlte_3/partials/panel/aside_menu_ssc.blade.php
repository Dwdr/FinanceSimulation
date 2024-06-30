<nav class="mt-3">
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
        @php
            // components path
            $group = 'layouts.adminlte_3.components.sidebar.group';
            $item = 'layouts.adminlte_3.components.sidebar.item';
            /**
             * group ($name,$route,$icon)
             * item ($name,$route,$icon='far fa-circle')
             */
        @endphp
        {{-- Dashboard --}}
        @include($item,['name' => __('aside_menu.dashboard'),'route' => 'ssc.dashboard.index','icon'=>'fas fa-home'])
        @include($item,['name' => __('aside_menu.leave_application'),'route' => 'ssc.leave_application.index','permissions' => config('constants.PERMISSION.EH-LEAVE-APPLICATION-R'),'icon'=>'fas fa-border-all'])
        @include($item,['name' => __('aside_menu.message'),'route' => 'ssc.message.index','icon'=>'far fa-comments'])
        @include($item,['name' => __('aside_menu.directory'),'route' => 'ssc.message.index','icon'=>'far fa-address-book'])
        @include($item,['name' => 'Documents','route' => 'ssc.message.index','icon'=>'fas fa-download'])
        @include($item,['name' => __('aside_menu.calendar'),'route' => 'ssc.calendar.index','icon'=>'far fa-calendar-alt'])
        @include($item,['name' => __('aside_menu.cico'),'route' => 'ssc.cico.index','permissions' => config('constants.PERMISSION.EH-CHECK-IO-R'),'icon'=>'fas fa-clock'])
        @include($item,['name' => __('aside_menu.faq'),'route' => 'ssc.faq.index','icon'=>"fas fa-question-circle"])
        @include($item,['name' => __('aside_menu.help'),'route' => 'ssc.help.index','icon'=>"fas fa-question-circle"])

        
    </ul>
</nav>
