<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            @foreach($model_cfg['list']['fields'] as $field_name =>$field_config)
                <td>
                    {{ $field_config['name'] }}
                </td>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($list as $value)
            <tr>
                @foreach($model_cfg['list']['fields'] as $field_name =>$field_config)
                    <td>
                        <?php
                        isset($field_config['_key']) && $field_name = $field_config['_key'];
                        ?>
                        @if($field_config['type'] == "text")
                            {{ $value->getAttribute($field_name) }}
                        @elseif($field_config['type'] == "image")
                            <img src="{{ $value->getAttribute($field_name) }}" style="max-width: 200px"/>
                        @elseif($field_config['type'] ==='quick_input')
                            @include('components.list.quick_input',[
                               'url'   => $field_config['url'].$value->getKey(),
                               'field' => $field_config['field'],
                               'value' => $value->$field_name,
                            ])
                        @elseif($field_config['type'] ==='quick_bool')
                            @include("components.list.quick_bool",[
                                 'id'    => $value->getKey(),
                                 'url'   => (isset($field_config['url'])? $field_config['url']: "/{$admin_route}/").$value->getKey(),
                                 'field' => $field_name,
                                 'value' => $value->$field_name,
                            ])
                        @elseif(is_callable($field_config['type']))
                            {!! call_user_func_array($field_config['type'],[$value]) !!}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    {!!  $list !!}
</div>