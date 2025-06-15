<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme no-print">
    <div class="app-brand demo ">
        <a href="{{ route('index') }}" class="app-brand-link">
            <span class="app-brand-logo demo" >
                <img src="{{asset('assets/img/DIL.png')}}" height="67" >
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto bg-dark">
            <i class="bx bx-transfer-alt bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Main Menu</span>
        </li>
        <li class="menu-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Resume</span>
        </li>
        @can('setting/manage_account/users.read')
        <li class="menu-item {{ request()->segment(1) == 'customer' ? 'active' : '' }}">
            <a href="{{ route('customer.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="customer">Customer</div>
            </a>
        </li>
        @endcan
        @can('setting/manage_account/users.read')
        <li class="menu-item {{ request()->segment(1) == 'institute' ? 'active' : '' }}">
            <a href="{{ route('institute.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-message-add"></i>
                <div data-i18n="institute">COA</div>
            </a>
        </li>
        @endcan
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Analysis</span>
        </li>
        @can('setting/manage_account/users.read')
        <li class="menu-item {{ request()->segment(1) == 'result' ? 'active' : '' }}">
            <a href="{{ route('result.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-analyse"></i>
                <div data-i18n="result">Final Analysis</div>
            </a>
        </li>
        @endcan
        @can('control panel.read')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Control Panel</span>
        </li>
        @endcan
        @can('setting.read')
        <li class="menu-item {{ request()->segment(1) == 'setting' ? 'open active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>Settings</div>
            </a>
            <ul class="menu-sub">
                @can('setting/manage_account.read')
                <li class="menu-item {{ request()->segment(2) == 'manage_account' ? 'open active' : '' }}">
                    <a href="" class="menu-link menu-toggle">
                        <div>Manage Account</div>
                    </a>
                    <ul class="menu-sub">
                        @can('setting/manage_account/users.read')
                        <li class="menu-item {{ request()->segment(3) == 'users' ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <div>Users</div>
                            </a>
                        </li>
                        @endcan
                        @can('setting/manage_account/roles.read')
                        <li class="menu-item {{ request()->segment(3) == 'roles' ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}" class="menu-link">
                                <div>Roles</div>
                            </a>
                        </li>
                        @endcan
                        @can('setting/manage_account/permissions.read')
                        <li class="menu-item {{ request()->segment(3) == 'permissions' ? 'active' : '' }}">
                            <a href="{{ route('permissions.index') }}" class="menu-link">
                                <div>Permissions</div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <li class="menu-item {{ request()->segment(2) == 'manage_coa' ? 'open active' : '' }}">
                    <a href="" class="menu-link menu-toggle">
                        <div>Manage Coa</div>
                    </a>
                    <ul class="menu-sub">
                        @can('setting/manage_account/users.read')
                        <li class="menu-item {{ request()->segment(1) == 'coa' ? 'active' : '' }}">
                            <a href="{{ route('coa.subject.index') }}" class="menu-link">
                                <div data-i18n="coa">COA</div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                <li class="menu-item {{ request()->segment(2) == 'manage_director' ? 'open active' : '' }}">
                    <a href="" class="menu-link menu-toggle">
                        <div>Manage Director</div>
                    </a>
                    <ul class="menu-sub">
                        @can('setting/manage_account/users.read')
                        <li class="menu-item {{ request()->segment(1) == 'director' ? 'active' : '' }}">
                            <a href="{{ route('director.index') }}" class="menu-link">
                                <div data-i18n="director">Director</div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
            </ul>
        </li>
        @endcan
    </ul>
</aside>
<!-- / Menu -->
