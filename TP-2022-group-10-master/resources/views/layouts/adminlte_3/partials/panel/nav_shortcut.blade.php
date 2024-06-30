{{-- Frequent-use shortcut, max 3 shortcuts --}}
{{-- TODO JL: design logic pls, LHS navbar is used to set frequent use module --}}
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        {{-- TODO fix org id later --}}
        {{--        <a href="{{ route('eh.dashboard.index') }}" class="nav-link">{{Auth::user()->profile->organization->name}}</a> --}}
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard" class="nav-link">Financial Simulator</a>
    </li>
</ul>
