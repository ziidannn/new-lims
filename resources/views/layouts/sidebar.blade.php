<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme no-print">
    <div class="app-brand demo ">
        <a href="{{ route('index') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="margin-left: -10px">
                <img src="{{asset('assets/img/DIL.png')}}" height="44" >
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
        @can('setting/manage_account/users.read')
        <li class="menu-item {{ request()->segment(1) == 'institute' ? 'active' : '' }}">
            <a href="{{ route('institute.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-area"></i>
                <div data-i18n="institute">Institute</div>
            </a>
        </li>
        @endcan
        @can('setting/manage_account/users.read')
        <li class="menu-item {{ request()->segment(1) == 'resume' ? 'active' : '' }}">
            <a href="{{ route('resume.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                <div data-i18n="resume">Resume</div>
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
                @endcan
            </ul>
        </li>
        @endcan
        @can('setting/manage_account/users.read')
        <li class="menu-item {{ request()->segment(1) == 'coa' ? 'active' : '' }}">
            <a href="{{ route('coa.regulation.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="coa">Manage COA</div>
            </a>
        </li>
        @endcan
    </ul>
</aside>
<!-- / Menu -->
