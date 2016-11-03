<?php
$show_value = $field . "_show";
$value      = $data->$show_value ? $data->$show_value : $data->$field;
$config_id  = $field;
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
                <span class="input-group-btn">
                    <button class="btn btn-primary action-upload-button"
                            upload-config='upload_config_{{ $config_id }}_##num##'
                            type="button">
                        上传
                    </button>
                     <button class="btn btn-danger action-remove-upload-button"
                             type="button">
                         删除
                     </button>
                </span>
        </div>
        <img src="##value_show##" onerror="refer_icon(this);" alt="image" id="pre_image_{{ $config_id }}_##num##" width="100" height="100">

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
    var refer_icon = function (that) {
        if (that.src.indexOf('{save}') == 0) {
            that.src = that.src.replace('{save}', 'http://s.197.so/ebianli/upload/');
        } else {
            that.src = '/static/image/error404.jpg';
        }
    };
    var close_this_layer = function (refer) {
        try {
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭
            if (refer) {
                parent.location.reload();
            }
        } catch (e) {

        }
    };
    seajs.use('admin/admin_field_images', function (field_images) {
        field_images.set_config('upload_config_{{ $config_id }}', {
            'web_upload': {
                'formData': {
                    'date': '{{ date("Ymd") }}',
                    'size': 2000 * 1024 * 1024,
                    'extensions': 'gif,jpg,jpeg,bmp,png',
                    'save_dir': 'upload/shop/',
                    'sign': '{!! md5('upload/shop/') !!}'
                },
                'accept': {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                fileSizeLimit: 2000 * 1024 * 1024
            },
            'success': function (file, response, child_widows) {
                $("#image_{{ $config_id }}").val('/' + response.data.file).trigger('change');
                // 关闭上传窗口
                var index = top.layer.getFrameIndex(child_widows.name);
                top.layer.close(index);

            }
        });

        @if(is_array($data->$field))
        @foreach($data->$field as $value)
        field_images.add_images("{{ $config_id }}", "{{ $value }}", "{{ $value }}");
        @endforeach
        @endif
    });
</script>