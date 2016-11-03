<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
            </a>

            <form role="search" class="navbar-form-custom" action="javascript:alert('功能开发中...');">
                <div class="form-group">
                    <input type="text" placeholder="搜索..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">欢迎使用易便利 - 管理后台</span>
            </li>
            <li>
                <a href="{{ URL::to('auth/logout') }}"> <i class="fa fa-sign-out"></i> 退出登录 </a>
            </li>
        </ul>

    </nav>
</div>