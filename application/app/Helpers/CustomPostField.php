<?php

namespace App\Helpers;

use \App\Models\PostField;
use App\Models\PostMeta;
use View;
use App\Helpers\Core;
use DB;
class CustomPostField{
  		/** Post */
  		public static function getData($meta_name, $post_id, $type){
          		if($type == 'Post'){
          		$data = PostMeta::where('meta_name', $meta_name)
                              ->where('post_id', $post_id)
                              ->first();
              }elseif($type == 'Category'){
                	$data = PostMeta::where('meta_name', $meta_name)
                              ->where('category_id', $post_id)
                              ->first();
              }

          		if(!empty($data)){

                  	return $data->meta_value;

                }else {
                  		return null;

                }


      }

        /**
         * $field_type =
         * text
         * textarea
         * richtext
         * select
         * single_image
         * multiple_image
         * checkbox
         * radio
         * colorpicker
         */


      public static function getField($termType, $post_id=null, $type=null){
          if($type == 'Post'){
            $field = PostField::where('term_type', $termType)->get();
          }elseif($type == 'Category'){
            $field = PostField::where('term_taxonomy_type', $termType)->get();
          }else{
            return 'need to pass parameter Field for (e.g, Post/Category)';
          }

          if(!empty($field)){
              $arr = [];
                foreach($field as $data){
                      $met= $data->field_type;
                      if (method_exists(static::class, $met)) {
                      $arr []= self::$met($data->field_title, $data->field_name, $data->field_type, $post_id, $type, $options = ['data' => $data]);
                        }
                }

              return $arr;


            }

            //return self::text('image', 'Image');

            //return $termType;

      }


      /**Text Field */
      public static function text($title, $name, $field_type, $post_id=null, $type=null, $options = []){
          $options = (object) $options;
          $html = '<div class="form-group">';
          $html .=  '<label for="'.$name.'">'.$title.'</label>';
          $html .=  '<input type="hidden"   name="custom_field['.$name.'][meta_name]" value="'.$name.'">';
          $html .=  '<input type="text" class="form-control form-control-sm 1" id="'.$name.'" name="custom_field['.$name.'][meta_value]" placeholder="Enter '.$title.'" value="'.self::getData($name, $post_id, $type).'" autocomplete="off">';
          $html .= '<div class="muted"><small>'.$options->data->note.'</small></div>';
          $html .=   '</div>';

          return $html;

      }

      /**Single Image Field */
      public static function single_image($title, $name, $field_type, $post_id=null, $type=null, $options = []){
          $options = (object) $options;
          ?>
            <div class="form-group">
                      <label for=""><?php echo $title ?></label>
                      <h3 class="card-title panel-title float-right">
                          <a type="button" data-toggle="modal" data-target="#<?php echo $name ?>" class="text-primary">Insert Image</a>
                      </h3>
                      <input type="hidden"   name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

                      <div class="<?php echo $name ?>img row mx-auto">
                          <!--  images and hidden fields -->
                              <?php
                                  $fimg = \App\Models\Media::where('id', self::getData($name, $post_id, $type))->first();
                              ?>
                              <?php if(!empty($fimg->id)) { ?>
                                  <div class="product-img product-images col-md-2 col-3">
                                      <input type="hidden" name="custom_field[<?php echo $name;?>][meta_value]" value="<?php echo $fimg->id;?>">
                                      <img class="img-fluid" src="<?php echo asset('/public/uploads/images/').'/'.$fimg->filename;?>">
                                      <a href="javascript:void()" class="remove"><span class="fa fa-trash"></span></a>
                                  </div>
                                <?php } ?>
                          <!-- dynamically added after  -->
                      </div>
                  </div>
            <?php echo \App\CustomClass\MediaManager::mediaScript();?>
            <?php
                    $inputName ='custom_field['.$name.'][meta_value]';
                  echo \App\CustomClass\MediaManager::media('single', $name, $name.'img', $inputName);?>
            <?php

      }


      /**Multiple Image Field */
      public static function multiple_image($title, $name, $field_type, $post_id=null, $type=null, $options = []){
          $options = (object) $options;
        ?>
            <div class="form-group">
                      <label for=""><?php echo $title ?></label>
                      <h3 class="card-title panel-title float-right">
                          <a type="button" data-toggle="modal" data-target="#<?php echo $name ?>" class="text-primary">Insert Image</a>
                      </h3>
                      <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

                      <div class="<?php echo $name ?>img row mx-auto">
                          <!--  images and hidden fields -->
                              <?php
                              $imgs = explode('|', self::getData($name, $post_id, $type)) ?? [];
//                              dump();
                              foreach($imgs as $id):
                                  $fimg = \App\Models\Media::where('id',$id)->first();
//                                  /dump($fimg);
                              ?>
                              <?php if(!empty($fimg->id)) { ?>
                                  <div class="product-img product-images col-md-2 col-3">
                                      <input type="hidden" name="custom_field[<?php echo $name;?>][meta_value][]" value="<?php echo $fimg->id;?>">
                                      <img class="img-fluid" src="<?php echo asset('/public/uploads/images/').'/'.$fimg->filename;?>">
                                      <a href="javascript:void()" class="remove"><span class="fa fa-trash"></span></a>
                                  </div>
                                <?php } endforeach; ?>
                          <!-- dynamically added after  -->
                      </div>
                    <div class="muted"><small><?php echo $options->data->note;?></small></div>
                  </div>
            <?php echo \App\CustomClass\MediaManager::mediaScript();?>
            <?php
                    $inputName ='custom_field['.$name.'][meta_value]';
                  echo \App\CustomClass\MediaManager::media('multiple', $name, $name.'img', $inputName);?>
            <?php

      }

      /** Color Picker Field */
      public static function colorpicker($title, $name, $field_type, $post_id=null, $type=null, $options = []){
        ?>
            <div class="form-group">
                <label for="<?php echo $name;?>"><?php echo $title ?></label>
                <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">
                <div class="input-group <?php echo $name;?> colorpicker-element" data-colorpicker-id="2">
                  <input type="text" class="form-control" data-original-title="" title="" name="custom_field[<?php echo $name;?>][meta_value]" placeholder="Enter <?php echo $title;?>" value="<?php echo self::getData($name, $post_id, $type);?>">

                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-square" style="color: <?php echo self::getData($name, $post_id, $type);?>"></i></span>
                  </div>
                </div>
            </div>
              <script>
                  //color picker with addon
                    document.addEventListener("DOMContentLoaded", function() {
                     loadColorPicker('.<?php echo $name;?>')
                    });

              </script>
          <?php
      }

      /** Rich Text */

    public static function richtext($title, $name, $field_type, $post_id=null, $type=null, $options = []){
        ?>
        <div class="form-group">
            <label for="<?php echo $name;?>"><?php echo $title ?></label>
            <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

            <textarea xid="compose-textareas" class="form-control compose-textarea-summernote" name="custom_field[<?php echo $name;?>][meta_value]"><?php echo self::getData($name, $post_id, $type);?></textarea>


        </div>

        <?php
    }

    public static function textarea($title, $name, $field_type, $post_id=null, $type=null, $options = []){
        ?>
        <div class="form-group">
            <label for="<?php echo $name;?>"><?php echo $title ?></label>
            <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

            <textarea class="form-control" name="custom_field[<?php echo $name;?>][meta_value]"><?php echo self::getData($name, $post_id, $type);?></textarea>


        </div>

        <?php
    }



    /* checkbox */
    public static function checkbox($title, $name, $field_type, $post_id=null, $type=null, $options = []){
        ?>
            <div class="form-group form-control">
                <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

                <label for="<?php echo $name;?>">
                    <input type="checkbox" class="" id="<?php echo $name;?>"
                        <?php echo self::getData($name, $post_id, $type) ==1 ?  'checked' :  null;?>
                           name="custom_field[<?php echo $name;?>][meta_value]"
                           value="<?php echo self::getData($name, $post_id, $type) ?? '1';?>">
                    <?php echo $title ?>
                </label>

            </div>
        <?php
    }



    public static function select($title, $name, $field_type, $post_id=null, $type=null, $options = []){
        $getOptions = $options ? $options['data'] : null;
        $getFieldTypeValue =$options ? $options['data']->field_type_value : null;
        $separateItem = $getFieldTypeValue ? explode('|', $getFieldTypeValue) : [];
        $joinTable = $getOptions->join_table ?? null;
        $joinColumn = $getOptions->join_column ?? null;
        $itemOptions = $joinTable ? DB::table($getOptions->join_table)->select($joinColumn)->get() : $separateItem;
        ?>

        <div class="form-group">
            <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

            <label for="<?php echo $name;?>"> <?php echo $title ?></label>

            <select class="form-control form-control-sm"  name="custom_field[<?php echo $name;?>][meta_value]">
                <option value="">Select <?php echo $title ?></option>
                <?php if($itemOptions) : foreach($itemOptions as $item):
                    $optionValue = $joinColumn ? $item->$joinColumn : $item;
                    ?>
                    <option
                        <?php echo self::getData($name, $post_id, $type) == $optionValue ? 'selected' : null ?>
                        value="<?php echo $optionValue ?>"><?php echo $optionValue ?></option>
                <?php endforeach; endif;?>
            </select>
        </div>
    <?php }

    //Add more
    public static function addmore($title, $name, $field_type, $post_id=null, $type=null, $options = []){
        $getFieldTypeValue =$options ? $options['data']->field_type_value : null;
        $separateItem = $getFieldTypeValue ? explode('|', $getFieldTypeValue) : null;
        //dump($separateItem);
        ?>
        <?php if(!empty($separateItem)):
            foreach($separateItem as $items) :
            $explodeThisItem = explode(':', $items) ?? null;
            $theName= $explodeThisItem[0];
            $inputType = $explodeThisItem[1] ?? null;
        ?>
        <div class="form-group">

            <label for="<?php echo $name;?>"><?php echo $title ?> </label>
            <input type="hidden" name="custom_field[<?php echo $name;?>][meta_name]" value="<?php echo $name; ?>">

            <textarea class="form-control" name="custom_field[<?php echo $name;?>][meta_value]"><?php echo self::getData($name, $post_id, $type);?></textarea>

        </div>
    <?php
        endforeach;
    endif;
    }



}
