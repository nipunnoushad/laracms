@extends('backend.layouts.master')

@section('site-title')
{{$taxonomy_name}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <form id="productForm" role="form" method="POST"
              action ="{{ (!empty($category)) ? route('backend_taxonomy_type_update'.$taxonomy_slug, [$term_slug, $taxonomy_slug]) : route('backend_taxonomy_type_store'.$taxonomy_slug, [$term_slug, $taxonomy_slug]) }}" senctype="multipart/form-data">
            @if(!empty($category))
                <input type="hidden" name="id" value="{{$category->id}}" />
            @endif
            @csrf
            <div class="card">
                <div class="card-header py-2 {{ (!empty($category)) ? ' alert-primary' : '' }}">
                    {{ (!empty($category)) ? 'Edit '.$taxonomy_name : 'Add '.$taxonomy_name }}
                </div><!-- end card-header-->
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group input-group-alt">
                            <label class="input-group-prepend" for="name">
                                <span class="input-group-text">Category Name</span>
                            </label>
                            <input type="text" class="form-control"
                                   id="category_title" name="name"
                                   placeholder="Enter category name" autocomplete="off"
                                   value="{{ (!empty($category)) ? $category->name : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alt">
                            <label class="input-group-prepend" for="slug">
                                <span class="input-group-text">Category Slug</span>
                            </label>
                            <input type="text" class="form-control{{ (!empty($category)) ? ' bg-secondary' : ' category_slug_active' }}"
                                   id="category_slug" name="slug" placeholder="Enter category Slug"
                                   value="{{ (!empty($category)) ? $category->slug : '' }}"
                                   autocomplete="off" {{ (!empty($category)) ? 'readonly' : '' }}>
                            @if(!empty($category))
                                <label for="slug_edit" class="input-group-prepend font-weight-normal text-success slug_fa" role="button" style="font-size: 10px;">
                                    <span class="input-group-text text-success"><i class="fas fa-edit"></i></span>
                                </label>
                                <input class="slug_edit d-none" id="slug_edit" name="slug_edit" type="checkbox">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <textarea class="form-control py-4 h-auto" id="description" name="description">{{ (!empty($category)) ? $category->description : '' }}</textarea>
                            <label for="description">
                                <span class="input-group-text border-0 shadow-none p-0 text-dark">Description</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alt ">
                            <label class="input-group-prepend" for="parent_id">
                                <span class="input-group-text">Parent Category</span>
                            </label>
                            <?php
                                global $taxSlug;
                                $taxSlug = $taxonomy_slug;
                                global $termSlug;
                                $termSlug = $term_slug;
                                global $catId;
                                $catId = (!empty($category)) ? $category->id : '';
                                global $avaiableCat;
                                $avaiableCat = (!empty($category)) ? $category->parent_id : '';

                                echo $avaiableCat;
                                function selectCat($parent_id = null, $sub_mark = "") {
                                    global $avaiableCat;
                                    global $taxSlug;
                                    global $termSlug;
                                    global $catId;
                                    $getCat = \App\Models\Category::where('parent_id', $parent_id)->where('taxonomy_type', $taxSlug)->orderBy('created_at', 'desc')->get();
                                    foreach($getCat as $row){ ?>
                                        @if($row->id != $catId)
                                            <option value="{{$row->id}}" {{$row->id == $avaiableCat ? 'selected' : ''}}>{{$sub_mark.$row->name}} </option>


                                        <?php selectCat($row->id, $sub_mark .'— '); ?>
                                        @endif
                                    <?php }
                                }?>
                            <select class="custom-select select2Cat" id="parent_id" name="parent_id">
                                <option value="">None</option>
                                <?php selectCat();?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="catimg">Category Image</label>
                        <a type="button" data-toggle="modal" data-target="#category" class="text-primary float-right">Insert Image</a>
                        <div class="catimg row mx-auto">
                                <!-- product images and hidden fields -->
                                @if((!empty($category)) && $category->image)
                                    <?php
                                        $cimg = \App\Models\Media::where('id', $category->image)->first();
                                    ?>
                                    @if(!empty($cimg->id))
                                        <div class="product-img product-images col-md-2 col-3">
                                            <input type="hidden" name="catimg_id" value="{{$cimg->id}}">
                                            <img class="img-fluid" src="{{asset('/public/uploads/images/').'/'.$cimg->filename}}">
                                            <a href="javascript:void()" class="remove"><span class="fa fa-trash"></span></a>
                                        </div>
                                    @endif
                                @endif
                                <!-- dynamically added after  -->
                        </div>
                    </div>

                    <!-- Custrom Field -->
                    <?php
          		        $customField = \App\Models\PostField::where('term_taxonomy_type', $taxonomy_slug)->get();
                    ?>

                    @if(count($customField) >0)
                    <div class="xcard">
                        <div class="card-header mb-1 card-info  {{ (!empty($post)) ? 'alert-primary' : '' }}">
                            Custom Field
                        </div>
                        <div class="xcard-body">
                            <?php
                            foreach(\App\Helpers\CustomPostField::getField($taxonomy_slug, $category->id ?? null, 'Category') as $data){
                                    echo $data;
                                } ?>
                        </div>
                    </div>
                    @endif
                    <!-- End -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- end card-body-->
            </div><!-- end card-->
        </form>
    </div><!-- end col-->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header py-2">
                 All {{$taxonomy_name}}
                <span class="float-right">
                    <a href="{{route('backend_taxonomy_type_index'.$taxonomy_slug, [$term_slug, $taxonomy_slug])}}" class="text-primary"> <i class="fa fa-plus"></i></a>
                </span>
            </div><!-- end card header-->
            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed table-hover table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name & Details</th>
                        <th>Count</th>
                        <th>Image</th>
                        <th>Date & Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $showCats = function ($parent_id = null, $sub_mark="") use ($ButtonSet, $taxSlug, $termSlug, $Model, &$showCats){
                        //global $taxSlug; // Assigned Up
                        //global $termSlug; // Assigned Up
                            $showCat = $Model('Category')::where('parent_id', $parent_id)->where('taxonomy_type', $taxSlug)->orderBy('id', 'desc')->get();
                            foreach($showCat as $data): ;?>
                                <tr class="">
                                    <td class="align-middle">{{$data->id}}</td>
                                    <td class="align-middle">
                                        <a target="_blank" class="text-primary" href="{{route('backend_term_type_index_by_category'.$termSlug, [$termSlug, $taxSlug, $data->id])}}">
                                            {{$sub_mark.$data->name}}
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        {{$Model('Post')::countPostByMultiCatId($data->id, $termSlug)}}
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        $cimg = $Model('Media')::where('id', $data->image)->first();
                                        ?>
                                        @if(!empty($cimg->id))
                                            <img style="width: 50px;" class="img-fluid" src="{{asset('/public/uploads/images/').'/'.$cimg->filename}}">
                                        @endif
                                    </td>
                                    <td class="align-middle">{{$data->created_at}}</td>
                                    <td class="align-middle">

                                        {!! $ButtonSet::edit('backend_taxonomy_type_edit'.$taxSlug, [$termSlug, $taxSlug, $data->id]) !!}
                                        {!! $ButtonSet::delete('backend_taxonomy_type_delete'.$taxSlug, [$termSlug, $taxSlug, $data->id]) !!}

                                    </td>
                                </tr>
                                <?php echo $showCats($data->id, $sub_mark .'— ');
                            endforeach;
                       }; ?>
                        {!! $showCats() !!}
                    </tbody>
                </table>
            </div><!-- end card body-->
        </div><!-- end card -->
    </div><!-- end col-->
</div><!-- end row-->
<?php
    echo \App\CustomClass\MediaManager::mediaScript();
    echo \App\CustomClass\MediaManager::media('single', 'category', 'catimg');
?>


@endsection



@section('cusjs')

<script>

        $(".slug_edit").change(function(){
            // console.log(this.checked)
            $("#category_slug").attr('readonly',!this.checked)
            if(this.checked == true){
                $("#category_slug").addClass('category_slug_active').removeClass('bg-secondary')
                $("label.slug_fa i").addClass('fa-check').removeClass('fa-edit')
            }
            if(this.checked == false){
                $("#category_slug").removeClass('category_slug_active').addClass('bg-secondary')
                $("label.slug_fa i").addClass('fa-edit').removeClass('fa-check')
            }
        })
            $("#category_title").keyup(function(){
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
                $(".category_slug_active").val(Text);
            });


 </script>




<script>
     //Select 2
    function selectRefresh() {
        $('select.select2Cat, select.select2Brand').select2({
            width: 'resolve'
        });
        //alert('hi');
    }
    selectRefresh();
</script>




@endsection
