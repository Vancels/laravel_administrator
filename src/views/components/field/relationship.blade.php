<?php

$name = $field_config['name'];
$name_field = $field_config['name_field'];
$obj = $data_value = $data->$name;
if ($obj == null) {
    $obj = $data->$name()->getRelated();
}
if (is_callable($field_config['options_filter'])) {
    $obj = call_user_func_array($field_config['options_filter'], [$obj]);
}
$select = $obj->get();
?>
<select class="bind_select2 form-control" name="data[{{$field}}]">
    <option value="">全部</option>
    @foreach($select as $value)
        <?php
        $pk = $value['primaryKey'];
        ?>
        <option value="{{ $value->$pk }}" {{ tool::a2bc($data_value == $value,true,"selected") }}>{{ $value->$name_field }}</option>
    @endforeach
</select>
<script>
    seajs.use('admin/admin_field_select2');
</script>