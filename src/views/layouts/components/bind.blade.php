{!! html::script('admin_asset/js/bootstrap.min.js') !!}
{!! html::script('admin_asset/js/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! html::script('admin_asset/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}
{!! html::script('admin_asset/js/plugins/jeditable/jquery.jeditable.js') !!}
<script>
    seajs.use('admin/bind_quick_status_edit');

    // 锁定左侧
    var body = $('body');
    body.addClass('fixed-sidebar');
    $('.sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });
</script>