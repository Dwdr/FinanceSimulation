<?php
$menu_open = false;
$match = preg_match_all('/http(.*)"/i', $item, $matches);
if(!isset($name)){
  $name = 'Unknown';
}
foreach ($matches[0] as $key => $url) { // $matches[0] is an array store all of the matched data
    $pure_url = trim(str_replace('"','', $url));
//    dump(request()->url(),'/'. preg_quote($pure_url, '/') . '*/',preg_match('/'. preg_quote($pure_url, '/') . '*/', request()->url()));
    if(preg_match('/'. preg_quote($pure_url, '/') . '*/', request()->url())){
        $menu_open = true;
        break;
    }
}

if(!isset($permissions)){
  $permissions = 'general';
}

?>

@canany($permissions)
<li class="nav-item{{$menu_open?' menu-open':null}}">
    <a href="#" class="nav-link{{$menu_open?' active':null}}">
        <i class="nav-icon {{$icon}}"></i>
        <p>
            {{ $name }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{$item}}
    </ul>
</li>
@endcanany
