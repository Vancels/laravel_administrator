<div class="bind-edit-box">
    <a class="btn btn-xs btn-primary bind-edit-button"> <i class="fa fa-pencil"></i></a>
    <span class="bind-edit-content">{{ $value }}</span>
    <input type="text" class="form-control bind-edit-input" style="display: none;" data-url="{{ $url }}" name="{{ $field }}" value="{{ $value }}" placeholder="">
</div>

<script>
    seajs.use('admin/bind_quick_input');
</script>