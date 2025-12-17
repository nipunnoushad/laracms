<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermTaxonomy;
use App\Models\Term;
use App\Models\Category;
use App\Models\PostMeta;

class CategoryController extends Controller
{
    protected $getTaxonomyName;
    protected $getTaxonomySlug;
    protected $getTermSlug;

    public function __construct(Request $request){
        $checkTaxonomy = TermTaxonomy::where('slug', $request->taxonomy)->where('term_type', $request->type)->first();
        if($checkTaxonomy) {
            $this->getTaxonomySlug = $checkTaxonomy['slug'];
            $this->getTaxonomyName = $checkTaxonomy['name'];
            $this->getTermSlug = $request->type;
        }
//        dd($request);
    }

    public function index(Request $request){
        $taxonomy_name = $this->getTaxonomyName;
        $taxonomy_slug = $this->getTaxonomySlug;
        $term_slug = $this->getTermSlug;

        if(empty($taxonomy_slug)){
           return view('backend.404', ['message' => 'Invalid Taxonomy Type']);
        }

        if($request->id){
            $category = Category::find($request->id);
        } else {
            $category = '';
        }

        return view('backend.category.index', compact('taxonomy_name', 'taxonomy_slug', 'term_slug', 'category'));
    }

     //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
        ]);

        $taxonomy_name = $this->getTaxonomyName;
        $taxonomy_slug = $this->getTaxonomySlug;
        $term_slug = $this->getTermSlug;

        if(empty($taxonomy_slug)){
           return view('backend.404', ['message' => 'Invalid Taxonomy Type']);
        } else {
            $data = new Category();
            $data->taxonomy_type = $taxonomy_slug;
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->parent_id = $request->parent_id;
            $data->image = $request->catimg_id;
            $data->is_status  = $request->is_status;
            $data->save();

            if(!empty($request->custom_field)){

                foreach($request->custom_field as $key => $custom){
                            //dump($custom['meta_name']);
                    $item = new PostMeta();
                    $item->category_id = $data->id;
                    $item->meta_name = $custom['meta_name'];
                    $item->meta_value = $custom['meta_value'];
                    $item->save();

                }

            }
            return redirect()->back()->with('success', 'Added Successfully');
        }

    }
    //update
    public function update(Request $request)
    {

        $taxonomy_name = $this->getTaxonomyName;
        $taxonomy_slug = $this->getTaxonomySlug;
        $term_slug = $this->getTermSlug;

        if(empty($taxonomy_slug)){
           return view('backend.404', ['message' => 'Invalid Taxonomy Type']);
        }  else {
            $data = Category::find($request->id);
            $data->taxonomy_type = $taxonomy_slug;
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->parent_id = $request->parent_id;
            $data->image = $request->catimg_id;
            $data->is_status  = $request->is_status;
            $data->save();


            if(!empty($request->custom_field)){
                foreach($request->custom_field as $key => $custom){
                    $items = PostMeta::where('meta_name', $custom['meta_name'])->where('category_id', $request->id)->first();
                    if(empty($items)){
                        $entry =  new PostMeta();
                    }else {
                        $entry = PostMeta::find($items->id);
                    }
                    $item =  $entry;
                    $item->category_id  = $request->id;
                    $item->meta_name = $custom['meta_name'];
                    $item->meta_value = $custom['meta_value'] ?? Null;
                    $item->save();
                            //dump($item);
                }

            }

            return redirect()->back()->with('success', 'Edited Successfully');
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id);
        //Chnage all child id which under this id
        $changeParent = Category::where('parent_id', $id)->get();
        if(!empty($changeParent)){
            foreach($changeParent as $change){
                $upParent = Category::where('parent_id', $id)->first();
                $upParent->parent_id = null;
                $upParent->save();
            }
        }

        $data->delete();
        return redirect()->back()->with('delete', 'Deleted Successfully');
    }
}
