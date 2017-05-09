@extends('layout.main')

@section('header')
    {!! html::style('css/plugins/toastr/toastr.min.css') !!}
    {!! html::style('css/plugins/iCheck/custom.css') !!}
@stop
@section('header_end')
    {!! html::style('css/plugins/chosen/chosen.css') !!}
    {!! html::style('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') !!}

    <script>
        var refer_icon = function (that) {
            that.src = '';
        }
    </script>
@stop
@section('js')

    {!! html::script('js/plugins/toastr/toastr.min.js') !!}
    {!! html::script('js/plugins/chosen/chosen.jquery.js') !!}
    {!! html::script('js/plugins/iCheck/icheck.min.js') !!}

    {{--表单验证--}}
    {!! html::script('js/plugins/validate/jquery.validate.min.js') !!}
    {!! html::script('js/plugins/validate/messages_zh.min.js') !!}

    <script>
        //以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: "span"/*,
             errorClass: "help-block m-b-none",
             validClass: "help-block m-b-none"*/
        });

        //以下为官方示例
        $(document).ready(function () {
            // validate the comment form when it is submitted
            $("#form").validate();
        });
    </script>


    <script>
        var close_this_layer = function (refer) {
            try {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                if (refer) {
                    parent.location.reload();
                }
            } catch (e) {

            }
        };

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });
        $('.chosen-select').chosen({
            allow_single_deselect: true,
            // disable_search_threshold: 10,
            no_results_text: '对不起,没有找到!'
        });


        $('#form').submit(function () {
            $.ajax({
                url: '{{ URL::route('admin.vest.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function (data) {
                    if (data.status) {
                        alert(data.msg);
                        close_this_layer(true);
                    } else {
                        toastr.error(data.msg);
                    }

                }
            });
            return false;
        });

    </script>


    <script>

        $("#image").change(function () {
            $("#pre_image").attr('src', $(this).val());
        });

    </script>
@stop

@section('footer')

@stop


@section('content')
    <?php


    ?>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">

        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    {{--<ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1"> Product info</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2"> Data</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3"> Discount</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-4"> Images</a></li>
                    </ul>--}}
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <?php
                                $primaryKey = $data['primaryKey'];
                                $method = $data->$primaryKey != null ? "PUT" : 'POST';
                                $admin_url = URL($admin_route . ($data->$primaryKey != null ? '/' . $data->$primaryKey : ""));
                                ?>
                                <form action="{{ $admin_url }}" method="POST">
                                    <input name="_method" type="hidden" value="{{ $method }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <fieldset class="form-horizontal">
                                        @include('administrator::components.edit',compact('data'))
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
