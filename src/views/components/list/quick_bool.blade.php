<div class="onoffswitch">
    <input type="checkbox" {{ $value ? "checked" : ""}} data-url="{{ $url }}" data-field="{{ $field }}" class="onoffswitch-checkbox action-bind-quick-status-edit" id="fast_bool_{{ $field }}_{{ $id }}">
    <label class="onoffswitch-label" for="fast_bool_{{ $field }}_{{ $id }}">
        <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
</div>