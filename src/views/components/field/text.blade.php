<?php
$show_value = $field . "_show";
$value      = $data->$show_value ? $data->$show_value : $data->$field;
?>
<input type="text" class="form-control" name="data[{{ $field }}]" value="{{ $value }}" placeholder="{{ $field_config['title'] }}">
