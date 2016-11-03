<div class="switch" style="padding: 10px 0 0 0">
    <div class="onoffswitch">
        <input type="hidden" name="data[{{ $field }}]" id="bool_{{ $field }}_hidden" value="{{ $data->$field }}"/>
        <input type="checkbox" {{ $data->$field ? "checked" : ""}}  class="onoffswitch-checkbox action-bind-form-bool" id="bool_{{ $field }}">
        <label class="onoffswitch-label" for="bool_{{ $field }}">
            <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
        </label>
    </div>
</div>

<script>
    seajs.use('admin/admin_field_bool');
</script>