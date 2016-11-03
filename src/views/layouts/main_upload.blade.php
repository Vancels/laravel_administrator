{{--上传--}}
{!! HTML::script('extra/upload/import_web_upload.js') !!}
<script>
    $(document).on('click', '.action-upload-button', function () {
        var cls = $(this);
        var cls_upload_name = cls.attr('upload-config');
        open_upload(cls_upload_name);
    });
</script>