<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'taxonomy_type',
        'is_status'
    ];

    public static function getCatByid($id){
        return Category::where('id', $id)->first();
    }

    public static function getCatByMultiid($ids ,$attr = 'name'){
        if($ids) {
            $exlplode = explode(',', $ids);
            $arr = [];
            foreach ($exlplode as $id) {
                $arr [] = Category::orderBy('id', 'desc')->whereRaw("FIND_IN_SET($id, id)")->first()->$attr;
            }
            return implode(' , ', $arr) ?? null;
        }else {
            return null;
        }

    }

    public static function taxonomy($taxonomy_type){
        return Category::where('taxonomy_type', $taxonomy_type)->get();
    }

    public static function name($id){
        return Category::where('id', $id)->first()->name;
    }
    public static function nameUseSlug($slug){
        return Category::where('slug', $slug)->first()->name;
    }

     public static function getSubCatByid($id){
        return Category::where('parent_id', $id)->get();
    }
}
