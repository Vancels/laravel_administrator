<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/admin_static/img/profile.jpg" width="48" height="48"/>
                             </span> <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::guard('admin')->user()->name }}</strong>
                             </span> <span class="text-muted text-xs block">系统管理员 <b class="caret"></b></span> </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ URL::to('/') }}">返回首页</a></li>
                        <li><a href="{{ URL::to('/debug_login?uid=2') }}" target="_blank">快速登陆</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('auth/logout') }}">退出登录</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    E+
                </div>
            </li>

            @foreach($nav as $nav_value)
                <li class="{{ $nav_value['selected'] }}">
                    <a href="{{ $nav_value['url'] }}"> <i class="fa fa-th-large"></i>
                        <span class="nav-label">{{ $nav_value['title'] }}</span>
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @foreach($nav_value['child'] as $child)
                            <li class="{{ $child['selected'] }}">
                                <a href="{{ $child['url'] }}">{{ $child['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>

            @endforeach


            <li class="special_link">
                <a href="//ebianli.197.so" target="_blank"><i class="fa fa-database"></i>
                    <span class="nav-label">易便利</span></a>
            </li>
        </ul>

    </div>
</nav>
