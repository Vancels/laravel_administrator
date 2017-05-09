<?php
$model_cfg = $model->getModel()->config_fields();
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ $model_cfg['list']['name'] }}列表</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ URL::to('/') }}">主页</a>
            </li>
            <li>
                <a>{{ $model_cfg['list']['name'] }}管理</a>
            </li>
            <li>
                <strong>{{ $model_cfg['list']['name'] }}列表</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content {{--animated fadeInRight--}}">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $model_cfg['list']['name'] }}列表
                        <small>清选择您需要管理的{{ $model_cfg['list']['name'] }},点击右侧管理按钮</small>
                    </h5>
                </div>
                <div class="ibox-content">
                    <form>
                        @if(isset($model_cfg['list']['search_bar_template']))
                            @include($model_cfg['list']['search_bar_template'])
                        @else
                            <div class="ibox-tools">
                                <a href="{{ URL($admin_route."/create") }}" class="btn btn-primary btn-xs">创建</a>
                            </div>
                            <div class="row">
                                <div class="col-sm-5 m-b-xs">
                                    @include('administrator::addon.shop_category')
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" class="input-sm form-control" name="bar_code" value="{{ Input::get('bar_code') }}" placeholder="条码">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" class="input-sm form-control" name="name" value="{{ Input::get('name') }}" placeholder="标题"> <span class="input-group-btn">
                                        <button class="btn btn-sm btn-primary" id="sub" type="submit">
                                            搜索
                                        </button> </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 m-b-xs">
                                    {{ form::select("feature",[''=>'推荐状态','0'=>'未推荐','1'=>'推荐'],Input::get('feature')) }}
                                    {{ form::select("has_image",[''=>'缩略图状态','0'=>'无缩略图','1'=>'有缩略图'],Input::get('has_image')) }}
                                    {{ form::select("status",[''=>'上架状态','0'=>'未上架','1'=>'已上架'],Input::get('status')) }}
                                </div>
                                <input type="hidden" name="order" value="" id="order_bys"/>
                                {{--<span style="float: right;padding-right: 20px;"><a href="javascript:void(0)" onclick="order_by('{{(Input::get('order')==''||Input::get('order')=='desc')  ?'asc':'desc'}}')">{{(Input::get('order')==''||Input::get('order')=='desc')  ?'按ID升序':'按ID降序'}}</a></span>--}}
                            </div>
                        @endif


                    </form>
                    @include('administrator::base.base_list_auto_field')

                </div>
            </div>
        </div>
    </div>
</div>

