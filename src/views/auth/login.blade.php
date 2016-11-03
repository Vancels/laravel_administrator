<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>易便利 - 登录</title>

    {!! HTML::style('admin_static/css/bootstrap.min.css') !!}
    {!! HTML::style('admin_static/font-awesome/css/font-awesome.css') !!}
    {!! HTML::style('admin_static/css/animate.css') !!}
    {!! HTML::style('admin_static/css/style.css') !!}

</head>
<body class="gray-bg">


<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">E+</h1>
        </div>
        <h3>欢迎使用 易便利 管理系统</h3>
        <form class="m-t" role="form" method="post" id="loginForm" action="">
            {!! csrf_field() !!}

            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="用户名" required="" value="{{ old('login_name') }}">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


            {{--<p class="text-muted text-center">
                <a href="login.html#">
                    <small>忘记密码了？</small>
                </a> | <a href="register.html">注册一个新账号</a>
            </p>--}}

        </form>
    </div>
</div>
{!! HTML::script('admin_static/js/jquery-2.1.1.js') !!}
{!! HTML::script('admin_static/js/bootstrap.min.js') !!}

{!! HTML::style('admin_static/css/plugins/toastr/toastr.min.css') !!}
{!! HTML::script('admin_static/js/plugins/toastr/toastr.min.js') !!}
<style>
    #toast-container > .toast-error::before {
        content: '';
    }
</style>
<script>
    $('#loginForms').submit(function () {
        var url = $(this).attr('action');
        var postData = $(this).serialize();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'Json',
            data: postData,
            success: function (data) {
                if (data.status == false) {
                    alert(data.msg);
                } else {
                    window.location.href = data.data;
                }
            }
        });

        return false;
    });
    toastr.options.timeOut = 6000000;
    @if ($errors->any())
    @foreach ($errors->all() as $message)
    toastr.error('{{ $message }}');
    @endforeach
    @endif
</script>
</body>
</html>

