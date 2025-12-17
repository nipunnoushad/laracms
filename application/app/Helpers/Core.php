<?php
namespace App\Helpers;
use DB;

class Core {
    /** Template Directory */
    public static function templateDir($arg){
       return resource_path('/views/frontend/templates/'.$arg);
    }
    /** Chcek Template File */
    public static function checkTemplateFile($dir, $filename){
      return file_exists(resource_path('/views/frontend/templates/'.$dir.'/'.$filename.'.blade.php'));
    }

    /**
     * customFieldFile
     *
     * @param  mixed $term_slug
     * @return void
     */
    public static function customFieldFile($term_slug){
       $dir = resource_path('/views/frontend/templates/'.$term_slug.'/custom-field/');
       if(is_dir($dir)){
         $template = array_diff(scandir($dir), array('.', '..'));
         $file = [];
         foreach($template as $item){
            $getFileName = explode(".blade.php", $item);
            $checkFile =  str_contains($item, '.blade.php');
            if($checkFile){
              //$keepField = strpos($getFileName[0], 'field-');
              $keepField = substr($getFileName[0], 0, 6) == 'field-';
              if($keepField !== false){
                $name = str_replace("field-",'',$getFileName[0]);
                $file [] = [
                  'title' => ucwords($name),
                  'name' => $getFileName[0],
                  'filepath' => 'frontend.templates.'.$term_slug.'.custom-field.'.$getFileName[0],
                ];
              }
                //$file []= $keepField;
            }
         }//End Foreach
         return $file ?? [];
       }
    }

    public static function customFieldFileLoad($term_slug, $fileName){
      $dir = resource_path('/views/frontend/templates/'.$term_slug.'/custom-field/');
      if(is_dir($dir)){
        $name = str_replace("field-",'query-',$fileName);
        $file = file_exists(resource_path('/views/frontend/templates/'.$term_slug.'/custom-field/'.$name.'.php'));
        if($file){
          $file_location = '/resources/views/frontend/templates/'.$term_slug.'/custom-field/'.$name.'.php';
          $request = request();
          include(base_path().$file_location);
        }
      }
    }

    public static function customFieldQuery($term_slug){
       $dir = resource_path('/views/frontend/templates/'.$term_slug.'/custom-field/');
       if(is_dir($dir)){
         $template = array_diff(scandir($dir), array('.', '..'));
          foreach($template as $item){
            $getFileName = explode(".php", $item);
            $checkFile =  str_contains($item, '.php');
            if($checkFile){
              //$keepField = strpos($getFileName[0], 'field-');
              $keepField = substr($getFileName[0], 0, 6) == 'query-';
              if($keepField !== false){
                $name = str_replace("query-",'',$getFileName[0]);
                $file [] = [
                  'title' => ucwords($name),
                  'name' => $getFileName[0],
                  'filepath' => 'frontend.templates.'.$term_slug.'.custom-field.'.$getFileName[0],
                ];
              }
                //$file []= $keepField;
            }
         }//End Foreach
         return $file ?? [];
       }
    }

    public static function customFieldDir($arg, $fieldFileName){
      $file = file_exists(resource_path('/views/frontend/templates/'.$arg.'/custom-field/'.'field-'.$fieldFileName.'.blade.php'));
      if($file){
       return resource_path('/views/frontend/templates/'.$arg.'/custom-field/','field-'.$fieldFileName);
      }else{
        return false;
      }
    }

    /**Post Conntent Limit Function */
    public static function limit($value, $limit = 100, $word = null, $end = null){
      $clearText = preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($value))) );

        if($word == null){
            if (mb_strwidth($clearText, 'UTF-8') <= $limit) {
                return $clearText;
            }
            //return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
        } else {
            $words = explode(" ",$clearText);
            return implode(" ", array_splice($words, 0, $limit)).$end;
        }



      //return substr($ClearText, 0, $limit);

    }


    /**
     * getEnumValues
     * From DB Table
     * @param  mixed $table
     * @param  mixed $column
     * @return void
     */
    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum((.*))$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
          $v = trim( $value, "(')" );
          $enum[strtolower($v)] = $v;
        }
        return $enum;
    }

    /**
     * hex2rgba
     *
     * @param  mixed $color
     * @param  mixed $opacity
     * @return void
     */
    public static function colorHex2rgba($color, $opacity = false) {

	    $default = 'rgb(0,0,0)';

      //Return default if no color provided
      if(empty($color))
              return $default;

      //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
              $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
              if(abs($opacity) > 1)
                $opacity = 1.0;
              $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
              $output = 'rgb('.implode(",",$rgb).')';
            }

            //Return rgb(a) color string
            return $output;
    }



    //Module
    public static function modules(){
        $scanModule = array_diff(scandir(root_path().'\application\module\\'), array('.', '..')) ?? [];
        return $scanModule ?? [];
    }


}
