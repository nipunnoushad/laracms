@php
/**
 * request()->get('warehouse_code')
 * its registered from
 * SingleWarehouseController
 * =========================
 * 1st parameter = 'Warehouse'
 * This define in to route/web.php
 * this use Show_for
 * Route group Property
 * */


if(request()->get('warehouse_code')){
    $homeLeftMenu = $NavMenu::showMenu('Left','Warehouse', request()->get('warehouse_code'));
}else{

}

$homeLeftMenuGlobal = $NavMenu::showMenu('Left');

if(request()->get('activeModule')){
    $moduleLeftMenu = $NavMenu::showMenu('Left', request()->get('module_name'), '');
    $homeLeftMenuGlobal = [];
}

$sideMenu = [
    $homeLeftMenuGlobal ?? [],
    $homeLeftMenu ?? [],
    $moduleLeftMenu ?? [],
];
@endphp
@foreach($sideMenu as $homeLeftMenu)
    @foreach ($homeLeftMenu as  $menus)
        @if($menus['routes'])
            <?php
                $routes = $menus['routes'];
                $menuItem = function () use($routes){
                    foreach($routes as $user): ?>
                        @if(count($routes) > 0)
                            <li class="menu-item {{Request::url() == $user['href'] ? 'text-primary has-active' : ''}}">
                                <a
                                    href="{{ $user['href'] }}"
                                    class="menu-link{{$user['db_status'] ? null : ' text-danger'}}">
                                    <i class="menu-icon {{ $user['route_icon'] }}"></i>
                                    <span class="menu-text">{{ $user['route_title'] }}</span>
                                </a>
                            </li>
                        @endif
              <?php endforeach; } ?>
                <li class="bt" >
                    @if($menus['index'] == null)
                        {!! $menuItem() !!}
                    @else
                    <li class="menu-item has-child {{$menus['is_current_active'] == true ? 'has-open' : null}}">
                        <a href="#" class="menu-link">
                            <span class="menu-icon oi oi-browser"></span>
                            <span class="menu-text">{{ $menus['index']}}</span>
                        </a>
                        <ul class="menu">
                            {!! $menuItem() !!}
                        </ul>
                    </li>
                    @endif
                </li>

        @endif
    @endforeach
@endforeach
