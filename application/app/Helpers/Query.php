<?php

namespace App\Helpers;

use DB;


class Query
{


    //Get Data
    public static function getData($table)
    {
        return DB::table($table)->get();
    }

    //Delete Data
    public static function delete($route, $id, $option=[])
    {
        $default = [
            'title' => null,
        ];
        $merge = array_merge($default, $option);
        //$html = \Form::open(array('url' => route($route, $id), 'method' => 'DELETE', 'style' => ''));
        $html = '<form method="POST" style="" action="'.route($route, $id).'">';
        $html .= '<input name="_method" type="hidden" value="DELETE">';
        $html .= csrf_field();
        $html .= '<button style="background: none;color: red;font-size: 14px;padding: 0 3px 0 0;" onclick=" return confirm(\'Are you sure?\')" title="' . $merge["title"] . '" type="submit" class="border-0 text-dark pr-0">
        <i class="far fa-trash-alt"></i><span class="sr-only">Remove</span> '.$merge["title"].'</button>';
        // $html .= \Form::close();
        $html .= '</form>';

        return $html;
    }

    /**
     * Access Any Model
     * From Models Directory
     */
    public static function accessModel($modelName)
    {
        $modelPath = '\App\Models' . '\\' . $modelName;
        return $modelPath;
    }

    /**
     * Datatable Get Data
     * use Api
     */
    public static function datatableData($arr = [])
    {

        $arr = [
            'model' => '',
            'arrdata'
        ];

    }

    /**
     * @param $table Put the table name here
     * @param $column Which column data will pull put it here
     * @return array Enum value will return as an array
     */
    public static function getEnumValues($table, $column)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type;
        preg_match('/^enum((.*))$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "(')");
            $enum[strtolower($v)] = $v;
        }
        return $enum;
    }

    /**
     * Update SQL table column enum
     *
     */
    public static function changeColumnEnumValues($options=[]){
        $default = [
            'table_name' => null,
            'column_name' => null,
            'enum_values' => [],
        ];
        $arr = array_merge($default, $options);
        $enum = "'".implode("','", $arr['enum_values'])."'";


        $query = DB::select(DB::raw("ALTER TABLE ".$arr['table_name']." MODIFY COLUMN ".$arr['column_name']." ENUM(".$enum.")"));

        return $query;
    }

    /**
     * @param $arg Table Row Name
     * @return mixed
     */
    public static function frontendSettings($arg)
    {
        return self::accessModel('FrontendSettings')::frontSetting($arg);
    }

    public static function globalSettings($arg)
    {
        return self::accessModel('GlobalSetting')::where('id', 1)->first()->$arg;
    }


}
