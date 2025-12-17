<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PostMeta;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'featured_image',
        'term_type',
        'category_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'meta_author',
        'template',
      	'sub_title',
      	'order_by',
      	'is_status',
        'author'
    ];

    //get Post By Category
    public static function category($category_id, array $option = []){
        $default = [
            'paginate' => null,
          	'orderBy'  => 'DESC',
          	'orderAs' => 'id'
        ];
        $data = (object)array_merge($default, $option);

        if(!empty($category_id)){
            if($data->paginate != null){
                return Post::orderBy($data->orderAs, $data->orderBy)->whereRaw("FIND_IN_SET($category_id, category_id)")->paginate ($data->paginate);
            }else {
                return Post::orderBy($data->orderAs, $data->orderBy)->whereRaw("FIND_IN_SET($category_id, category_id)")->get();
            }
        }
    }

    public static function term($term_type, array $option = []){
        $default = [
            'paginate' => null
        ];
        $data = (object)array_merge($default, $option);
        
        if(!empty($term_type) && $data->paginate != null){
            return Post::orderBy('id', 'DESC')->where('term_type', $term_type)->paginate ($data->paginate);
        } else {
            return Post::orderBy('id', 'DESC')->where('term_type', $term_type)->get();
        }
        

    }

    public static function getPostByCat($category_id){
        $getPost = Post::where('category_id', $category_id)->orderBy('id', 'DESC')->get();
        return $getPost;
    }
    public static function postByMultiCatId($category_id, $term_slug, $optional_order = false){
      
      	if(!empty($optional_order) && $optional_order = true) {
          if(!empty($category_id)){
              return Post::orderBy('post_order', 'ASC')->whereRaw("FIND_IN_SET($category_id, category_id)")->where('term_type', $term_slug);
          } 
        } else {
          if(!empty($category_id)){
              return Post::orderBy('id', 'DESC')->whereRaw("FIND_IN_SET($category_id, category_id)")->where('term_type', $term_slug);
          }  
        }
        
    }

    //Count
    public static function countPostByMultiCatId($category_id, $term_slug){
        if(!empty($category_id)){
            return count(Post::whereRaw("FIND_IN_SET($category_id, category_id)")->where('term_type', $term_slug)->get());
        }
    }
  
  
  //Custom Field
  public static function customField($meta_name, $post_id){
    	$data = PostMeta::where('meta_name', $meta_name)->where('post_id', $post_id)->first();
    	if(!empty($data)){
          	return $data->meta_value;
        } else {
          return null;
        }
    
  }
  
  
}
