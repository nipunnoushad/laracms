<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCustomField extends Model
{
    use HasFactory;
    protected $table = 'post_custom_fields';
    protected $fillable = [
        'post_id', 'category_id', 'field_file', 'field_value', 'field_for'
    ];

    public static function getData($post_id, $field_file){
        $check = PostCustomField::where('post_id', $post_id)->where('field_file', $field_file)->where('field_for', 'Post')->first();
        if($check){
            $jsondata = $check->field_value;
            if($jsondata){
                return json_decode($jsondata, true);
            }else {
                return $check->field_value ?? null;
            }
        }
       
    }
}
