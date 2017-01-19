<?php
namespace Vancels\Administrator\Service;

class AdminAutoService
{

    public static function createTable($name, $fields)
    {
        \Schema::create($name, function (\Illuminate\Database\Schema\Blueprint $table) use ($fields) {
            foreach ($fields as $value) {
                $table->string($value);
            }
        });
    }

    /**
     * 样式文件 - label
     * label-primary 绿
     * label-success 蓝
     * label-warning 黄
     * label-danger  红
     *
     *
     * @param $status
     * @param $name
     *
     * @return string
     */
    public static function field_view_status_label($status, $name, $true_class = 'label-primary', $false_class = 'label-default')
    {
        $status = $status ? $true_class : $false_class;

        return '<span class="label ' . $status . '">' . $name . '</span> ';
    }


    /**
     * 返回combox_value值
     *
     * @param      $key
     * @param null $param
     *
     * @return mixed
     */
    public static function combox_value($key, $param = null)
    {
        if ($param == null) {
            $param = \Input::all();
        }
        if (isset($param[$key . '_primary_key'])) {
            return $param[$key . '_primary_key'];
        }

        return false;
    }

}