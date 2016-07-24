<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->present()->avatar }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->present()->nameOrEmail }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('app.online')</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="{{ Ekko::isActiveRoute('dashboard') }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard fa-fw"></i> <span>@lang('app.dashboard')</span>
                </a>
            </li>

                <li class="{{ Ekko::isActiveRoute('user.list') }}">
                    <a href="{{ route('user.list') }}">
                        <i class="fa fa-users fa-fw"></i> <span>@lang('app.users')</span>
                    </a>
                </li>



                <li class="{{ Ekko::isActiveRoute('activity.index') }}">
                    <a href="{{ route('activity.index') }}">
                        <i class="fa fa-list-alt fa-fw"></i> <span>@lang('app.activity_log')</span>
                    </a>
                </li>

                <li class="{{ Ekko::areActiveRoutes(['role.index', 'dashboard.permission.index']) }} treeview">
                    <a href="#">
                        <i class="fa fa-user fa-fw"></i>
                        <span>@lang('app.roles_and_permissions')</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">

                            <li class="{{ Ekko::isActiveRoute('role.index') }}">
                                <a href="{{ route('role.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    @lang('app.roles')
                                </a>
                            </li>

                            <li class="{{ Ekko::isActiveRoute('dashboard.permission.index') }}">
                                <a href="{{ route('dashboard.permission.index') }}">
                                   <i class="fa fa-circle-o"></i>
                                   @lang('app.permissions')</a>
                            </li>

                    </ul>
                </li>





















            <li class="{{ Ekko::isActiveMatch('log-viewer') }} treeview">
                <a href="#">
                	<i class="fa fa-file-text-o fa-fw"></i>
                    <span>Log Viewer</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Ekko::isActiveRoute('log-viewer::dashboard') }}">
                        <a href="{!! url('dashboard/log-viewer') !!}">Dashboard</a>
                    </li>
                    <li class="{{ Ekko::isActiveRoute('log-viewer::logs.list') }}">
                        <a href="{!! url('dashboard/log-viewer/logs') !!}">Logs</a>
                    </li>
                </ul>
            </li>

            <li class="{{ Ekko::areActiveRoutes(['settings.general', 'settings.auth', 'settings.notifications']) }} treeview">
                <a href="#">
                    <i class="fa fa-gear fa-fw"></i>
                    <span>@lang('app.settings')</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                        <li class="{{ Ekko::isActiveRoute('settings.general') }}">
                            <a href="{{ route('settings.general') }}">
                               <i class="fa fa-circle-o"></i>
                                @lang('app.general')
                            </a>
                        </li>

                        <li class="{{ Ekko::isActiveRoute('settings.auth') }}">
                            <a href="{{ route('settings.auth') }}">
                               <i class="fa fa-circle-o"></i>
                                @lang('app.auth_and_registration')
                            </a>
                        </li>

                        <li class="{{ Ekko::isActiveRoute('settings.notifications') }}">
                            <a href="{{ route('settings.notifications') }}">
                               <i class="fa fa-circle-o"></i>
                                @lang('app.notifications')
                            </a>
                        </li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>