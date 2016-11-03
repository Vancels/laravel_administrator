@include('components.list.quick_input',[
'url'   => '/admin/shop_items/'.$value->id,
'field' => 'cost_price',
'value' => $value->cost_price_show,
'bind'=>++$bind['quick_input'],
])


@include("components.list.quick_bool",[
                                            'id'    => $value->id,
                                            'url'   => '/admin/shop_items/'.$value->id,
                                            'field' => 'status',
                                            'value' => $value->status,
                                            ])