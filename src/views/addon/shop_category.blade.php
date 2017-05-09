<?php
$item_category  = \Vancels\Administrator\Models\AdminUser::get();
$selected_value = Input::get("cat_id");
?>
{!! html::style('css/plugins/select2/select2.min.css') !!}
{!! html::script('js/plugins/select2/select2.full.min.js') !!}
<select class="select2_demo_1 form-control" name="cat_id">
    <option value="">全部</option>
    @foreach($item_category as $value_category)
        <option value="{{ $value_category->id }}" {{ \vTools::a2bc((string) $value_category->id === $selected_value,true,"selected") }}>{{ $value_category->name }}</option>
    @endforeach
</select>
<script>
    $(".select2_demo_1").select2();
</script>