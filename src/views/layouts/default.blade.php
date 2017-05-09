<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>@yield('seo_title','易便利 - 管理后台')</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    {!! html::style('admin_asset/css/bootstrap.min.css') !!}
    {!! html::style('admin_asset/font-awesome/css/font-awesome.css') !!}
    {!! html::script('admin_asset/js/jquery-2.1.1.js') !!}
    {!! html::script('admin_asset/extra/layer/layer.js') !!}
    {!! html::script('admin_asset/extra/seajs/sea.js') !!}
    {!! html::script('admin_asset/extra/seajs/seajs-css.js') !!}
    {!! html::script('admin_asset/extra/seajs/admin_config_seajs.js') !!}

    {{--@include('layout.main_upload')--}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        seajs.use('admin/component_toastr');
    </script>

    @yield('header')
    {!! html::style('admin_asset/css/animate.css') !!}
    {!! html::style('admin_asset/css/style.css') !!}
    @yield('header_end')
    @include('administrator::public.header')

</head>

<body>

<div id="wrapper">
    @include('administrator::public.nav')
    <div id="page-wrapper" class="gray-bg">
        @include('administrator::public.top')
        {!! $content !!}
        @include('administrator::public.footer')
    </div>
</div>


<!-- Mainly scripts -->
@include("administrator::layouts.components.bind")
@yield('js')
        <!-- Custom and plugin javascript -->
{!! html::script('admin_asset/js/inspinia.js') !!}
<script>
    seajs.use('plugin_js/pace/pace.min');
    seajs.use('plugin_js/iCheck/icheck.min');
    seajs.use('admin/bind_ajax_combox');
</script>
@yield('administrator::footer');
</body>
</html>
