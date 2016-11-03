<?php

$value   = $data->$field;
$options = [];
foreach ($field_config['options'] as $val => $text) {
    $options[] = array(
            'id'   => is_numeric($val) ? $text : $val,
            'text' => $text,
    );
}

?>
<select class="bind_select2 form-control" name="data[{{$field}}]">
    <option value="">请选择</option>
    @foreach($options as $option)
        <option value="{{ $option['id'] }}" {{ tool::a2bc($option['id'] == $value,true,"selected") }}>
            {{ $option['text'] }}
        </option>
    @endforeach
</select>
<script>
    seajs.use('admin/admin_field_select2');
</script>