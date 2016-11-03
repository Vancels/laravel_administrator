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

<textarea id="template_add_{{ $config_id }}" style="display: none;">
<div class="ibox images_ibox">
    <div class="ibox-title">
        <h5>点击拖拽</h5>

        <div class="ibox-tools">
            <label class="label label-primary">您可以进行拖拽至其他位置</label>
        </div>
    </div>
    <div class="ibox-content">
        <div class="input-group">
            <input type="text" class="form-control" name="data[{{ $field }}][]" id="image_{{ $config_id }}_##num##" placeholder="{{ $field_config['title'] }}" value="##value##"/>
                <span class="input-group-btn" id="upload_config_{{ $config_id }}_##num##_container">
                    <button class="btn btn-primary"
                            id='upload_config_{{ $config_id }}_##num##_container_pick_file'
                            type="button">
                        上传
                    </button>
                     <button class="btn btn-danger action-remove-upload-button"
                             type="button">
                         删除
                     </button>
                </span>
        </div>
        <img src="##value_show##" onerror="refer_icon(this);" alt="image" id="pre_image_{{ $config_id }}_##num##" width="100" >

    </div>
</div>
</textarea>
<div>
    <button class="btn btn-primary action-images-upload-button" data-config="{{ $config_id }}"
            type="button">
        添加图片
    </button>
</div>
<div style="padding: 10px 0px">
    <div class="ui-sortable " id="sortable-view-{{ $config_id }}">
    </div>
</div>


<script>

    // domain, token, container, FileUploadedCallable, key_handle
    seajs.use('admin/admin_field_images', function (field_images) {
        field_images.set_config('upload_config_{{ $config_id }}', {
            domain: '{{ config('filesystems.disks.qiniu.domains.default') }}',
            token: '{{ $token }}',
            container: 'upload_config_{{ $config_id }}_##num##_container',
            FileUploadedCallable: function (sourceLink, up, file, info) {
                console.log(sourceLink);
                //$("#image_{{ $config_id }}").val(sourceLink).trigger('change');
                // $("#image_{{ $config_id }}").val('/' + response.data.file).trigger('change');
            },
            key_handle: function (up, file) {
                var key = "";
                // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                // 该配置必须要在 unique_names: false , save_key: false 时才生效
                var ext = Qiniu.getFileExtension(file.name);
                key = ext ? file.id + '.' + ext : file.id;
                // do something with key here
                return 'upload/{{ date('ym') }}/{{ date('d') }}' + key
            }
        });

        @if(is_array($data->$field))
        @foreach($data->$field as $value)
        field_images.add_images("{{ $config_id }}", "{{ $value }}", "{{ $value }}");
        @endforeach
        @endif
    });
</script>