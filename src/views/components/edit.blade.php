<?php
$config_fields = $data->config_fields();
?>
@foreach($config_fields['default'] as $field => $field_config)
    <?php
    isset($field_config['type']) || $field_config['type'] = "text";
    ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ $field_config['title'] }}
            :</label>
        <div class="col-sm-10">
            @include("administrator::components.field.".$field_config['type'],['data'=>$data])
        </div>
    </div>
@endforeach

<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <button class="btn btn-white" type="reset">重填</button>
        <button class="btn btn-primary" type="submit">保存</button>
    </div>
</div>
