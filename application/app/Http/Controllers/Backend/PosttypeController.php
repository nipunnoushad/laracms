<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\TermTaxonomy;
class PosttypeController extends Controller
{
    protected $postType;
    protected $taxonomy;

    public function __construct(Term $postType, TermTaxonomy $taxonomy){
        $this->postType = $postType;
        $this->taxonomy = $taxonomy;
    }


    public function index(){
        return view('backend.settings.post-type.index');
    }


    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:'.(new $this->postType)->getTable().',slug',
        ]);

        $postType = [
            'name' => $request->name,
            'slug' => $request->slug
        ];
        $this->postType::create($postType);

        
        try {
            return redirect()->back()->with(['status' => 1, 'message' => 'Successfully Added']);
        } catch (\Exception $e) {
            //dd($e->errorInfo[2]);
            $errormsg = $e->errorInfo[2];
        }

    }
}
