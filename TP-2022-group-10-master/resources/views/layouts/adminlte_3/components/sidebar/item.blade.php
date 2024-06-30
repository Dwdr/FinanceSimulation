<?php
$regex = '/' . preg_quote(str_replace('index', '', $route) , '/') . '\.*/';
if(!isset($icon)){
    $icon = 'far fa-circle';
}
$match = preg_match($regex, Route::currentRouteName());
if(request()->is('/')&&$route=='eh.dashboard.index'){
  $match = true;
}
?>
@if(isset($permissions))
    @can($permissions)
        <li class="nav-item">
            <a href="{{ route($route) }}"
               class="nav-link{{$match ? ' active' : null}}">
                <i class="nav-icon {{$icon}} "></i>
                <p>{{ $name }}</p>
            </a>
        </li>
    @endcan
@else
    <li class="nav-item">
        <a href="{{ route($route) }}"
           class="nav-link{{$match ? ' active' : null}}">
            <i class="nav-icon {{$icon}} "></i>
            <p>{{ $name }}</p>
        </a>
    </li>
@endif

