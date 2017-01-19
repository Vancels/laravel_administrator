<?php

namespace Vancels\Administrator\Models;

trait AdminCommonModel
{
    public function config_fields()
    {
        $class = get_class($this);
        $class = explode("\\", $class);
        $class = array_pop($class);

        return include app_path("Models") . "/fields/{$class}Fields.php";
    }

    /**
     * 获取table信息
     *
     * @return array
     */
    public function infoTable()
    {
        $sql   = "select * from information_schema.columns where table_name = '{$this->getTable()}'";
        $data  = \DB::select($sql);
        $table = [];
        foreach ($data as $value) {
            $table[$value->COLUMN_NAME] = $value;
        }

        return $table;
    }

    public function infoTableConfig($tables = null)
    {
        if ($tables == null) {
            $tables = $this->infoTable();
        }
        $data = [];
        foreach ($tables as $key => $value) {
            $data[$key]['title'] = !empty($value->COLUMN_COMMENT) ? $value->COLUMN_COMMENT : $value->COLUMN_NAME;
            $data[$key]['type']  = 'text';
        }

        echo "<pre>";
        var_export($data);
        echo "</pre>";
    }


    public static function throw_error($msg = "")
    {
        throw new \Exception($msg);
    }

}
