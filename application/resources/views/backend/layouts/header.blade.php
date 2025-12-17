<!-- .app-header -->
<header class="app-header app-header-light bg-white">
    <!-- .top-bar -->
    <div class="top-bar">
        <!-- .top-bar-brand -->
        <div class="top-bar-brand">
            <!-- toggle aside menu -->
            <button class="hamburger hamburger-squeeze mr-2" type="button" data-toggle="aside-menu"
                aria-label="toggle aside menu"><span class="hamburger-box"><span
                        class="hamburger-inner"></span></span></button> <!-- /toggle aside menu -->
            <a href="#">
                {{env('APP_NAME') ?? 'RiptWare'}}
            </a>
        </div><!-- /.top-bar-brand -->
        <!-- .top-bar-list -->
        <div class="top-bar-list">
            <!-- .top-bar-item -->
            <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                <!-- toggle menu -->
                <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside"
                    aria-label="toggle menu"><span class="hamburger-box"><span class="hamburger-inner"></span></span>
                </button> <!-- /toggle menu -->
            </div><!-- /.top-bar-item -->
            <!-- .top-bar-item -->
            <div class="top-bar-item top-bar-item-full">
                <!-- .top-bar-search -->
                @hasSection('page-title')
                    @yield('page-title')
                @endif
            </div><!-- /.top-bar-item -->
            <!-- .top-bar-item -->
            <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">
                <!-- .nav -->
                @hasSection('header-filter')
                    <div style="height: 29px;">
                        @yield('header-filter')
                    </div>
                @endif
                <ul class="header-nav nav">
                    <!-- .nav-item -->

                    <li class="nav-item">
                        <a href="{{ route('upload_routelist') }}" title="Reload Routelist" class="nav-link">
                            <i class="fas fa-sync"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown header-nav-dropdown">
                        <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="oi oi-grid-three-up"></span></a> <!-- .dropdown-menu -->
                        <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right " x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 36px; left: -276px;">
                            <div class="dropdown-arrow"></div><!-- .dropdown-sheets -->
                            <div class="dropdown-sheets">
                                <!-- .dropdown-sheet-item -->
                                <div class="dropdown-sheet-item">
                                    <a href="{{route('backend_dashboard')}}" class="tile-wrapper">
                                        <span class="tile tile-lg bg-primary">
                                            <i class="oi oi-globe"></i>
                                        </span>
                                        <span class="tile-peek">Website</span>
                                    </a>
                                </div><!-- /.dropdown-sheet-item -->
                                @foreach($Core::modules() as $module)
                                    <div class="dropdown-sheet-item">
                                        <a href="{{route('module_'.strtolower($module).'_index')}}" class="tile-wrapper">
                                            <span class="tile tile-lg bg-warning">
                                                <i class="oi oi-person"></i>
                                            </span>
                                            <span class="tile-peek">{{$module}}</span>
                                        </a>
                                    </div><!-- /.dropdown-sheet-item -->
                                @endforeach

                            </div><!-- .dropdown-sheets -->
                        </div><!-- .dropdown-menu -->
                    </li>
                </ul><!-- /.nav -->
                <!-- .btn-account -->
                <div class="dropdown d-none d-md-flex">
                    <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="user-avatar user-avatar-md">
                            <img src="{{$backendDir}}/assets/images/avatars/profile.jpg" alt="">
                            </span>
                        <span class="account-summary pr-lg-4 d-none d-lg-block">
                            <span
                                class="account-name">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                            <span class="account-description">{{ auth()->user()->userRole()->name }}</span>

                        </span>
                    </button> <!-- .dropdown-menu -->
                    <div class="dropdown-menu">
                        <div class="dropdown-arrow d-lg-none" x-arrow=""></div>
                        <div class="dropdown-arrow ml-3 d-none d-lg-block"></div>
                        <h6 class="dropdown-header d-none d-md-block d-lg-none"> {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h6>
                        <a class="dropdown-item" href="#">
                            <span class="dropdown-icon oi oi-person"></span> Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                                <span class="dropdown-icon oi oi-account-logout"></span>
                            Logout
                        </a>
                        <?php /*
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Help Center</a> <a
                            class="dropdown-item" href="#">Ask Forum</a> <a class="dropdown-item" href="#">Keyboard
                            Shortcuts</a>*/ ?>
                    </div><!-- /.dropdown-menu -->
                </div><!-- /.btn-account -->
            </div><!-- /.top-bar-item -->
        </div><!-- /.top-bar-list -->
    </div><!-- /.top-bar -->
</header><!-- /.app-header -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@include('backend.layouts.aside_left')
