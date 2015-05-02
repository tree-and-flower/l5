<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">同行旅游票务管理系统</a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            {{Auth::user()->name}}<i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#"><i class="fa fa-user fa-fw"></i> 个人信息</a>
            </li>
            <li><a href="#"><i class="fa fa-gear fa-fw"></i> 设置</a>
            </li>
            <li class="divider"></li>
            <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->
<!-- /.navbar-static-side -->
