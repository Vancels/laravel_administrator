<input size="16" type="text" name="data[{{ $field }}]" value="{{ $data->$field }}" class="input-xs form-control bind-time" placeholder="{{ $field_config['title'] }}"/>
<script>
    seajs.use('admin/admin_field_time');
</script>