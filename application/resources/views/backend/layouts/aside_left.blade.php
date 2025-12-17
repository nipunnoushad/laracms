<!-- .app-aside -->
<aside class="app-aside app-aside-expand-md app-aside-light bg-white">
    <!-- .aside-content -->
    <div class="aside-content">
        <!-- .aside-header -->
        <header class="aside-header d-block d-md-none">
            <!-- .btn-account -->
            <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside">
                <span class="user-avatar user-avatar-lg">
                    <img src="{{$backendDir}}/assets/images/avatars/profile.jpg" alt=""></span>
                    <span class="account-icon"><span class="fa fa-caret-down fa-lg"></span>
                </span>
                <span class="account-summary">
                    <span class="account-name"> {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                    <span class="account-description">{{ auth()->user()->userRole()->name }}</span>
                </span>
            </button> <!-- /.btn-account -->
            <!-- .dropdown-aside -->
            <div id="dropdown-aside" class="dropdown-aside collapse">
                <!-- dropdown-items -->
                <div class="pb-3">
                    <a class="dropdown-item" href="#"><span class="dropdown-icon oi oi-person"></span> Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                        <span class="dropdown-icon oi oi-account-logout"></span>
                        Logout
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"></a>
                </div><!-- /dropdown-items -->
            </div><!-- /.dropdown-aside -->
        </header><!-- /.aside-header -->
        <!-- .aside-menu -->
        <div class="aside-menu overflow-hidden">
            <!-- .stacked-menu -->
            <nav id="stacked-menu" class="stacked-menu">

                <!-- .menu -->
                <ul class="menu">
                    @include('backend.layouts.nav-menu.left-sidebar-menu')
                    <!-- .menu-item -->
                </ul><!-- /.menu -->
            </nav><!-- /.stacked-menu -->
        </div><!-- /.aside-menu -->
        <!-- Skin changer -->
        <footer class="aside-footer border-top p-2">
            <button class="btn btn-light btn-block text-primary" data-toggle="skin"><span class="d-compact-menu-none">Night mode</span> <i class="fas fa-moon ml-1"></i></button>
        </footer><!-- /Skin changer -->
    </div><!-- /.aside-content -->
</aside><!-- /.app-aside -->
