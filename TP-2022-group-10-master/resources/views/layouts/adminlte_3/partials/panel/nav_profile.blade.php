<ul class="navbar-nav ml-auto">
    {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-globe"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-0">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                    class="dropdown-item @if ($localeCode == app()->getLocale()) active @endif">
                    {{ $properties['native'] }}
                </a>
            @endforeach
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="{{ route('eh.message.show', [app()->getLocale(), 'demo']) }}" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                    <img src="{{ asset('images/user.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            Brad Diesel
                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">Call me whenever you can...</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div>
                <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('eh.message.show', [app()->getLocale(), 'demo']) }}" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                    <img src="{{ asset('images/user.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            John Pierce
                            <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">I got your message bro</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div>
                <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('eh.message.show', [app()->getLocale(), 'demo']) }}" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                    <img src="{{ asset('images/user.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            Nora Silvester
                            <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">The subject goes here</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div>
                <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('eh.message.index', app()->getLocale()) }}" class="dropdown-item dropdown-footer">See All
                Messages</a>
        </div>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-lightbulb"></i>
        </a>
    </li> --}}
    @include('layouts.adminlte_3.components.modal', [
        'type' => 'logout',
        'modal_name' => 'modal_logout',
        'msg_heading' => __('auth.logout.logout'),
        'msg_question' => __('auth.logout.are-you-sure-you-wanna-logout'),
        'btn_name' => '<i class="nav-icon fas fa-sign-out-alt"></i> ' . __('auth.logout.logout'),
        'btn_class' => 'nav-link',
        'btn_msg_yes' => __('auth.logout.yes-logout'),
        'btn_msg_no' => __('auth.logout.no-stay-here'),
        'url' => null,
    ])
</ul>

@push('body_end_scripts')
    <script>
        $('.dropdown-toggle').dropdown()
    </script>
@endpush
