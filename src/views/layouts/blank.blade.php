<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>@yield('seo_title','易便利 - 管理后台')</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    {!! HTML::style('admin_static/css/bootstrap.min.css') !!}
    {!! HTML::style('admin_static/font-awesome/css/font-awesome.css') !!}
    {!! HTML::script('admin_static/js/jquery-2.1.1.js') !!}
    {!! HTML::script('admin_static/extra/layer/layer.js') !!}
    {!! HTML::script('admin_static/extra/seajs/sea.js') !!}
    {!! HTML::script('admin_static/extra/seajs/seajs-css.js') !!}
    {!! HTML::script('admin_static/extra/seajs/admin_config_seajs.js') !!}




    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        seajs.use('admin/component_toastr');
    </script>

    @yield('header')
    {!! HTML::style('admin_static/css/animate.css') !!}
    {!! HTML::style('admin_static/css/style.css') !!}
    @yield('header_end')
    @include('administrator::public.header')

</head>

<body>

<div id="wrapper">
    <div class="gray-bg">
        {!! $content !!}
    </div>
</div>


<!-- Mainly scripts -->
@include("administrator::layouts.components.bind")
@yield('js')
        <!-- Custom and plugin javascript -->
{!! HTML::script('admin_static/js/inspinia.js') !!}
<script>
    seajs.use('plugin_js/pace/pace.min');
    seajs.use('plugin_js/iCheck/icheck.min');
    seajs.use('admin/bind_ajax_combox');
</script>
@yield('administrator::footer');
</body>
</html>
