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
{{--        @include($item,['name' => __('aside_menu.message'),'route' => 'ssc.message.index','icon'=>'far fa-comments'])--}}
{{--        @include($item,['name' => __('aside_menu.directory'),'route' => 'ssc.message.index','icon'=>'far fa-address-book'])--}}
{{--        @include($item,['name' => 'Documents','route' => 'ssc.message.index','icon'=>'fas fa-download'])--}}
{{--        @include($item,['name' => __('aside_menu.calendar'),'route' => 'ssc.calendar.index','icon'=>'far fa-calendar-alt'])--}}

        @include($item,['name' => __('aside_menu.job'),'route' => 'jobs.job.index','icon'=>'fas fa-suitcase'])

    @switch(Auth::user()->getRoleNames()[0])
            @case(config('constants.ROLE.JOBS-ADMIN'))
            @include($item,['name' => __('aside_menu.banner'),'route' => 'jobs.banner.index','icon'=>'fas fa-glass-cheers'])
            @include($item,['name' => __('aside_menu.post'),'route' => 'jobs.post.index','icon'=>'fas fa-glass-cheers'])
            @include($item,['name' => __('aside_menu.employer'),'route' => 'jobs.employer.index','icon'=>'fas fa-street-view'])
            @include($item,['name' => __('aside_menu.seeker'),'route' => 'jobs.seeker.index','icon'=>'far fa-graduation-cap'])
            @include($item,['name' => __('aside_menu.portfolio'),'route' => 'jobs.portfolio.index','icon'=>'fas fa-glass-cheers'])
            @break
            @case(config('constants.ROLE.JOBS-EMPLOYER'))
            @include($item,['name' => __('aside_menu.employer'),'route' => 'jobs.employer.self_edit','icon'=>'fas fa-street-view'])
            @include($item,['name' => __('aside_menu.seeker'),'route' => 'jobs.seeker.index','icon'=>'far fa-graduation-cap'])
            @include($item,['name' => __('aside_menu.portfolio'),'route' => 'jobs.portfolio.index','icon'=>'fas fa-glass-cheers'])
            @break
            @case(config('constants.ROLE.JOBS-SEEKER'))
            @include($item,['name' => __('aside_menu.seeker'),'route' => 'jobs.seeker.self_edit','icon'=>'far fa-graduation-cap'])
            @include($item,['name' => __('aside_menu.portfolio'),'route' => 'jobs.portfolio.index','icon'=>'fas fa-glass-cheers'])
            @break
        @endswitch

        @include($item,['name' => __('aside_menu.faq'),'route' => 'ssc.faq.index','icon'=>"fas fa-question-circle"])
        @include($item,['name' => __('aside_menu.help'),'route' => 'ssc.help.index','icon'=>"fas fa-question-circle"])
    </ul>
</nav>
