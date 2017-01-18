<?php

namespace App\Http\Controllers\Admin;

use App\Models\CommonModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Redirect;
use Route;
use Vancels\Administrator\AdminController;
use vTools;
use URL;
use View;

use Illuminate\Session\SessionManager as Session;

class AdminAutoController extends AdminController
{
    /**
     * @var CommonModel $model
     */
    public $model;
    public $admin_route = 'admin/shop_items';
    public $_cfg = [
        'view_list'   => 'admin.base_list',
        'view_create' => 'admin.base_create',
    ];

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
        $nav = $this->_getNav();
        View::share('nav', $nav);
        View::share('admin_route', $this->admin_route);
        // 开启调试
        if (env('APP_ENV') == 'local') {
            \DB::enableQueryLog();
        }

        // 监控UPDATE INSERT DELETE 的 操作
        \DB::listen(function ($sql) {
            if (strpos($sql->sql, "update") !== false
                || strpos($sql->sql, "delete") !== false
                || strpos($sql->sql, "insert") !== false
            ) {
                $sql->sql = str_replace("?", "'%s'", $sql->sql);
                $sql      = array_merge([$sql->sql], $sql->bindings);
                $sql      = call_user_func_array("sprintf", $sql);
                \Log::info("后台[" . \Auth::user()->id . "] 执行SQL操作", [$sql]);
            }
        });

        $this->_initialize();
    }

    protected function _initialize()
    {
    }

    private function _getNav()
    {
        $nav = [];

        $nav[] = ['title' => '商品管理', 'url' => URL::to('admin/message/index'), 'selected' => vTools::a2bc(Route::currentRouteName() != 'admin.users.index', true, 'active'), 'child' => vTools::callReturn(function () {
            $child[] = ['title' => '分类管理', 'url' => URL::route('admin.shop_category.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.shop_category") !== false, true, 'active')];
            $child[] = ['title' => '商品列表', 'url' => URL::route('admin.shop_items.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.shop_items") !== false, true, 'active')];
            //$child[] = ['title' => '团购列表', 'url' => URL::route('admin.tuan_goods.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.tuan_goods") !== false, true, 'active')];
            $child[] = ['title' => '拼团商品', 'url' => URL::route('admin.pin.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.pin") !== false, true, 'active')];
            $child[] = ['title' => '广告管理', 'url' => URL::route('admin.ad.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.ad") !== false, true, 'active')];
            $child[] = ['title' => '提现管理', 'url' => URL::route('admin.extract.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.extract") !== false, true, 'active')];
            $child[] = ['title' => '收银管理', 'url' => URL::route('admin.cashier.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.cashier") !== false, true, 'active')];
            $child[] = ['title' => '会员管理', 'url' => URL::route('admin.user.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.user") !== false, true, 'active')];
            $child[] = ['title' => '会员订单', 'url' => URL::route('admin.orders.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.orders") !== false, true, 'active')];
            $child[] = ['title' => '会员拼团', 'url' => URL::route('admin.teams.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.teams") !== false, true, 'active')];
            $child[] = ['title' => '支付记录', 'url' => URL::route('admin.pay_record.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.pay_record") !== false, true, 'active')];

            //$child[] = ['title' => '后台模板', 'url' => URL::route('admin.template.index'), 'selected' => vTools::a2bc(strpos(Route::currentRouteName(), "admin.template") !== false, true, 'active')];
            //$child[] = ['title' => '奖品列表', 'url' => URL::route('admin.award.index'), 'selected' => vTools::a2bc(Route::currentRouteName(), 'admin.vest.index', 'active')];
            //$child[] = ['title' => '回复列表', 'url' => URL::route('admin.messages.index'), 'selected' => vTools::a2bc(Route::currentRouteName(), 'admin.messages.index', 'active')];

            //$child[] = ['title' => '回复统计', 'url' => URL::route('admin.messages.statistics'), 'selected' => vTools::a2bc(Route::currentRouteName(), 'admin.messages.statistics', 'active')];

            return $child;
        }),];

        // 管理网站编辑权限
        if (\Auth::user() && in_array(\Auth::user()->role, [1, 2, 4])) {

            $nav[] = ['title' => '网编帐号管理', 'url' => URL::route('admin.users.index'), 'selected' => vTools::a2bc(Route::currentRouteName() == 'admin.users.index', true, 'active'), 'child' => vTools::callReturn(function () {

                $child[] = ['title' => '帐号管理', 'url' => URL::route('admin.users.index'), 'selected' => vTools::a2bc(Route::currentRouteName(), 'admin.users.index', 'active')];

                return $child;
            }),];
        }

        return $nav;
    }


    /**
     * @param CommonModel $model
     * @param Request     $request
     *
     * @return mixed
     */
    public function _where($model, Request $request)
    {
        $info = $model->infoTable();

        foreach ($info as $field => $field_config) {
            $value = ToolServiceInterface::combox_value($field);
            $value || $value = $request->get($field);

            if ($value !== null) {
                $model = $model->where($field, $value);
            }
        }

        $model = $model->orderBy($model->getModel()->create(), 'DESC');

        return $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $request = \Request::instance();
        $param   = $request->all();

        /** @var CommonModel $cls */
        $cls  = $this->model;
        $cls  = $this->_where($cls, $request);
        $list = $cls->paginate();
        $list->appends($param);

        return view($this->_cfg['view_list'], ['list' => $list, 'model' => $cls]);
    }

    public function create()
    {
        return view($this->_cfg['view_create'], ['data' => $this->model]);
    }

    public function store()
    {
        $request = \Request::instance();
        $data    = $this->model;

        $post_data     = $request->get("data");
        $config_fields = $this->model->config_fields();
        foreach ($config_fields['default'] as $field => $field_config) {
            //isset($field_config['type']) || $field_config['type'] = 'text';

            switch ($field_config['type']) {
                case 'bool':
                    if (isset($post_data[$field])) {
                        $data->$field = ($post_data[$field] == "on" || $post_data[$field] == "1") ? 1 : 0;
                    }

                    break;
                case 'text':
                default:
                    if (isset($post_data[$field]) && $post_data[$field] !== null) {
                        $data->$field = $post_data[$field];
                    }
                    break;
            }
        }

        if ($request->get('ajax') == 1) {
            if ($data->save()) {
                return json_encode(['status' => 1, 'msg' => '修改成功']);
            } else {
                return json_encode(['status' => 0, 'msg' => '修改失败']);
            }
        } else {
            if ($data->save()) {
                return Redirect::back();
            } else {
                return Redirect::back()->withInput()->withErrors('保存失败！');
            }
        }
    }

    public function edit($id)
    {
        return view($this->_cfg['view_create'], ['data' => $this->model->find($id)]);
    }


    public function show($id)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return response('ERROR', 404);
        }

        return view($this->_cfg['view_create'], ['data' => $data]);
    }

    public function update($id)
    {
        $request = \Request::instance();
        $data    = $this->model->find($id);

        $post_data     = $request->get("data");
        $config_fields = $this->model->config_fields();
        foreach ($config_fields['default'] as $field => $field_config) {
            //isset($field_config['type']) || $field_config['type'] = 'text';

            switch ($field_config['type']) {
                case 'bool':
                    if (isset($post_data[$field])) {
                        $data->$field = ($post_data[$field] == "on" || $post_data[$field] == "1") ? 1 : 0;
                    }

                    break;
                case 'text':
                default:
                    if (isset($post_data[$field]) && $post_data[$field] !== null) {
                        $data->$field = $post_data[$field];
                    }
                    break;
            }
        }

        if ($request->get('ajax') == 1) {
            if ($data->save()) {
                return json_encode(['status' => 1, 'msg' => '修改成功']);
            } else {
                return json_encode(['status' => 0, 'msg' => '修改失败']);
            }
        } else {
            if ($data->save()) {
                return Redirect::back();
            } else {
                return Redirect::back()->withInput()->withErrors('保存失败！');
            }
        }
    }


    public function destroy($id)
    {
        $page = $this->model->find($id);
        $page->delete();

        return Redirect::to('admin');
    }
}
