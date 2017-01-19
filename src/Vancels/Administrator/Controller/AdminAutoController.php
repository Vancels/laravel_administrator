<?php

namespace Vancels\Administrator\Controller;

use App\Models\CommonModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Redirect;
use Vancels\Administrator\AdminController;
use Vancels\Administrator\Service\AdminAutoService;
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
        'view_list'   => 'administrator::base.base_list',
        'view_create' => 'administrator::base.base_create',
    ];

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
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
            $value = AdminAutoService::combox_value($field);
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
        $request = app("request");
        $param   = $request->all();

        /** @var CommonModel $cls */
        $cls  = $this->model;
        $cls  = $this->_where($cls, $request);
        $list = $cls->paginate();
        $list->appends($param);

        $this->layout->content = view($this->_cfg['view_list'], ['list' => $list, 'model' => $cls]);

        return $this->layout;
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
