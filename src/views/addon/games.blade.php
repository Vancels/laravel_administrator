<input type="text" name="cat_id" action-rel="ajax-combox" ajax-url="{!! URL::to('admin/shop_category/combox?test=123&codeing=123') !!}" placeholder="请选择分类" value="{{ Input::get('cat_id') }}">