<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            @if (Auth::user()->role == 'admin')
            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> 客户管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @foreach (Config::get('tongxing.jingdian') as $k => $v) 
                        <li>
                            <a href="/customer/jingdian/{{$k}}">{{$v}}</a>
                        </li>
                        @endforeach
                    </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 用户管理<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/users">用户管理</a>
                    </li>
                </ul>
            </li>
            @else
            @foreach (Config::get('tongxing.jingdian') as $k => $v) 
            @if (in_array($k, explode(',', Auth::user()->role)))
            <li>
                <a href="/jingdian/{{$k}}"><i class="fa fa-sitemap fa-fw"></i>{{$v}}</a>
            </li>
            @endif
            @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- /.sidebar-collapse -->
