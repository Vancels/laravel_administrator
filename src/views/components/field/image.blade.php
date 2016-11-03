<?php
$show_value = $field . "_show";
$value      = $data->$show_value ? $data->$show_value : $data->$field;
$config_id  = $field;

$bucket    = config('filesystems.disks.qiniu.bucket');
$accessKey = config('filesystems.disks.qiniu.access_key');
$secretKey = config('filesystems.disks.qiniu.secret_key');

$auth  = new \Qiniu\Auth($accessKey, $secretKey);
$token = $auth->uploadToken($bucket);

//config('filesystems.disks.qiniu.domains.default')
$qiniu_container = "qiniu_{$field}_container";
?>
<div class="">
    <div class="input-group">
        <input type="text" class="form-control" name="data[{{ $field }}]" id="image_{{ $config_id }}" placeholder="{{ $field_config['title'] }}" value="{{ $data->$field or '' }}"/>
            <span class="input-group-btn" id="{{ $qiniu_container }}">
                <button class="btn btn-primary" id="{{ $qiniu_container }}_pick_file"
                        type="button">
                    上传
                </button>
            </span>
    </div>
    <img src="{{ $value or '#' }}" onerror="refer_icon(this);" alt="image" id="pre_image_{{ $config_id }}" width="100" >
</div>
<script>

    $("#image_{{ $config_id }}").change(function () {
        $("#pre_image_{{ $config_id }}").attr('src', $(this).val());
    });


    seajs.use('admin/admin_field_qiniu', function (qiniu_cls) {
        qiniu_cls.init('{{ config('filesystems.disks.qiniu.domains.default') }}', '{{ $token }}', '{{ $qiniu_container }}', function (sourceLink, up, file, info) {
            $("#image_{{ $config_id }}").val(sourceLink).trigger('change');
        }, function (up, file) {
            var key = "";
            // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
            // 该配置必须要在 unique_names: false , save_key: false 时才生效
            var ext = Qiniu.getFileExtension(file.name);
            key = ext ? file.id + '.' + ext : file.id;
            // do something with key here
            return 'upload/{{ date('ym') }}/{{ date('d') }}' + key
        });
    });


</script>