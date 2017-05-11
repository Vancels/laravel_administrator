<?php
$show_value = $field . "_show";
$value      = $data->$show_value ? $data->$show_value : $data->$field;
$placeholder = isset($field_config['desc']) ?$field_config['desc']: $field_config['title'];
?>
<input type="hidden" class="form-control" name="data[{{ $field }}]" value="{{ $value }}" placeholder="{{ $placeholder }}">
