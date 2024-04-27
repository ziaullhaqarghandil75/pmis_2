<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class=" waves-effect waves-dark" href="\" aria-expanded="false"><i class="icon-home"></i><span class="hide-menu">دشبورد</span></a></li>
                @can('setting_users')
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">تنظیمات حساب کابری</span></a>
                        <ul aria-expanded="false" class="collapse">
                        @can('roles')
                            <li><a href="{{ route('role.index') }}">سطح دسترسی</a></li>
                        @endcan
                        @can('permissions')
                            <li><a href="{{ route('permission.index') }}">سطوح دسترسی</a></li>
                        @endcan
                        @can('users')
                            <li><a href="{{ route('user.index') }}">کاربران</a></li>
                        @endcan
                        </ul>
                    <li>
                @endcan
                @can('setting_plans')
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">تنظیمات پلان</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @can('departments')
                            <li><a href="{{ route('department.index') }}">دیپارتمنت ها</a></li>
                            @endcan
                            @can('goals')
                            <li><a href="{{ route('goal.index') }}">اهداف </a></li>
                            @endcan
                            @can('units')
                            <li><a href="{{ route('unit.index') }}">واحد ها</a></li>
                            @endcan
                            @can('districts')
                            <li><a href="{{ route('district.index') }}">نواحی</a></li>
                            @endcan
                        </ul>
                    <li>
                @endcan
                @can('setting_projects')
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">تنظیمات پروژه ها</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @can('projects')
                            <li><a href="{{ route('project.index') }}">پروژه ها</a></li>
                            @endcan
                        </ul>
                    <li>
                @endcan
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>