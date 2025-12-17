<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Term;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\Category;
use App\Helpers\Core;
use View;
use App\Models\PostCustomField;

class PostController extends Controller
{
    protected $getTermSlug;
    protected $getTermName;
    protected $getCatId;
    protected $getCatName;

    public function __construct(Request $request){
        $checkTerm = Term::where('slug', $request->type)->first();
//        dd($request);
        if($checkTerm) {
            $this->getTermSlug = $checkTerm['slug'];
            $this->getTermName = $checkTerm['name'];
        }
        if($request->categoryid){
            $checkCat = Category::where('id', $request->categoryid)->first();
            $this->getCatId = $checkCat['id'];
            $this->getCatName = $checkCat['name'];
        }
    }

    //index
    public function index()
    {
        $term_name = $this->getTermName;
        $term_slug = $this->getTermSlug;
        $cat_id = $this->getCatId;

        if(empty($term_slug)){
           return view('backend.404', ['message' => 'Invalid Post Type']);
        }
        if(!empty($cat_id)){
            $getPost = Post::postByMultiCatId($cat_id, $term_slug)->paginate('15');
            $catName = $this->getCatName;
        } else {
            $getPost = Post::where('term_type', $term_slug)->orderBy('created_at', 'desc')->paginate('15');
            $catName = '';
        }
        return view('backend.post.index', compact('getPost', 'term_name', 'term_slug', 'catName'));
    }

    //form
    public function form(Request $request)
    {
        $term_name = $this->getTermName;
        $term_slug = $this->getTermSlug;

        if(empty($term_slug)){
           return view('backend.404', ['message' => 'Invalid Post Type']);
        }else {

            if($request->id){
                $post = Post::find($request->id);
            } else {
                $post = '';
            }

            return view('backend.post.form', compact('term_slug', 'term_name', 'post'));
        }
    }
    //store
    public function store(Request $request)
    {
      //dd($request->all());
      //die();
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:posts,slug',
        ]);
        $term_name = $this->getTermName;
        $term_slug = $this->getTermSlug;

        $getLastOrder = Post::where('term_type', $term_slug)->latest()->first()->order_by+1 ?? 1;

        if(empty($term_slug)){
           return view('admin.404', ['message' => 'Invalid Post Type']);
        } else {
            $featured_image = $term_slug.'img_id';
            $category = !empty($request->category_id) ? implode(",", $request->category_id) : '';
            $data = new Post();
            $data->term_type = $term_slug;
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->featured_image = $request->$featured_image;
            $data->category_id = $category;
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keyword = $request->meta_keyword;
            $data->meta_author = $request->meta_author;
            $data->template  = $request->template;
            $data->sub_title  = $request->sub_title;
            $data->order_by  = $getLastOrder;
            $data->is_status  = $request->is_status;
            $data->author  = auth()->user()->id;
            $data->save();

          //Custom Field

          	if(!empty($request->custom_field)){

                    foreach($request->custom_field as $key => $custom){
                                //dump($custom['meta_name']);
                        $item = new PostMeta();
                        $item->post_id = $data->id;
                        $item->meta_name = $custom['meta_name'];
                        $item->meta_value = $custom['meta_value'];
                        $item->save();

                    }

            }
            return redirect()->route('backend_term_type_edit'.$term_slug, [$term_slug, $data->id])->with('success', 'Added Successfully');
        }

    }

  	// 'sub_title', 'post_order'

    //update
    public function update(Request $request)
    {
        $term_name = $this->getTermName;
        $term_slug = $this->getTermSlug;

        if(empty($term_slug)){
           return view('admin.404', ['message' => 'Invalid Post Type']);
        } else {
            $featured_image = $term_slug.'img_id';
            $category = !empty($request->category_id) ? implode(",", $request->category_id) : '';
            $data = Post::find($request->id);
            $data->term_type = $term_slug;
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->featured_image = $request->$featured_image;
            $data->category_id = $category;
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keyword = $request->meta_keyword;
            $data->meta_author = $request->meta_author;
            $data->template  = $request->template;
          	$data->sub_title  = $request->sub_title;
            // $data->order_by  = $request->order_by;
            $data->is_status  = $request->is_status;
            $data->save();


          	if(!empty($request->custom_field)){

                foreach($request->custom_field as $key => $custom){
                          $items = PostMeta::where('meta_name', $custom['meta_name'])->where('post_id', $request->id)->first();
                            if(empty($items)){
                                $items =  new PostMeta();
                            }
                          $item = $items;
                          $item->post_id  = $request->id;
                          $item->meta_name = $custom['meta_name'];
                          $item->meta_value = $custom['meta_value'] ?? Null;
                          $item->save();
                         //dump($item);

                }

            }

            return redirect()->back()->with('success', 'Edited Successfully');
        }
    }

    //delete
    public function destroy(Request $request)
    {
        $data = Post::find($request->id);
        $data->delete();
        return redirect()->back()->with('delete', 'Deleted Successfully');
    }

    //custom field
    public function customFieldDataStore(Request $request){
        //dd($request->all());
        $term_slug = $this->getTermSlug;
        Core::customFieldFileLoad($term_slug, $request->custom_field_file);
        return redirect()->back()->with('success', 'Updated Successfully');
    }


    //Update Order /Position
    public function updateOrder(Request $request)
    {
        $term_slug = $this->getTermSlug;
        $posts = Post::where('term_type', 'page')->get();
        foreach ($posts as $post) {
            $post->timestamps = false; // To disable update_at field updation
            $id = $post->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $tr = Post::where('id', $id)->update(['order_by' => $order['position']]);
                    // dump($order);
                }
            }

        }

        return response('Update Successfully.', 200);
    }



    public function apiGet(Request $request){
        $term_slug = $this->getTermSlug;
        $query = $this->Model('Post')::where('term_type', $term_slug);
        $phpCode =  '
                $imgLink = $thiss->Model("Media")::fileLocation($data->featured_image);
                $img = "<img class=\"img-fluid\" src=\"{$imgLink}\"  />";

                $title =  "<div class=\"media align-items-center\" title=\"ID {$data->id}\">";
                    $title .= !empty($imgLink) ? "<span class=\"user-avatar user-avatar-lg mr-3\">{$img}</span>" : null;
                    $title .= "<div class=\"media-body\">";
                    $title .= "<h3 class=\"card-title\"> {$data->name}</h3> ";
                    $title .= "<h6 class=\"card-subtitle text-muted\">/{$data->term_type}/{$data->slug}</h6>";
                    $title .= "</div>";
                $title .= "</div>";
        ';

        $fields  = [
            'button' =>  '
                $this->ButtonSet::edit("backend_term_type_edit'.$term_slug.'", ["'.$term_slug.'", $data->id]).
                $this->ButtonSet::delete("backend_term_type_delete'.$term_slug.'", ["'.$term_slug.'", $data->id])
            ',
            'id' => '$data->id',
            'order_by' => '$data->order_by',
            'name' => '$title',
            'category' =>  '$this->Model("Category")::getCatByMultiid($data->category_id, "name")',
            'created_at' => '$data->is_status. "<br>" .$data->created_at->format("d M y H:i a")',
        ];

        return $this->Datatable::generate($request, $query, $fields,   ['daterange' => 'updated_at', 'phpcode' => $phpCode, 'orderby' => 'order_by' ]);
    }
}
