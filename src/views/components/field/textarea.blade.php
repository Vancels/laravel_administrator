<?php
$show_value = $field . "_show";
$value      = $data->$show_value ? $data->$show_value : $data->$field;
?>
<textarea type="text" class="form-control" name="data[{{ $field }}]" placeholder="{{ $field_config['title'] }}">{{ $value }}</textarea>
