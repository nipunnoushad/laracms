@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())

@section('content-filter')
    <div id="dt_filter"></div>
@endsection

@section('contents')
    <div class="card card-fluid d-none">
        <div class="card-header py-2">
             {{ !empty($catName) ? $catName : 'All '. $term_name  }}
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed table-hover table-sm">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($getPost as $key => $data)
                <tr>
                    <td class="align-middle">{{$key + $getPost->firstItem()}}</td>
                    <td class="align-middle">
                        <?php
                            $fimg = \App\Models\Media::where('id', $data->featured_image)->first();
                        ?>
                        @if(!empty($fimg->id))
                            <img style="width: 50px;" class="img-fluid" src="{{asset('/public/uploads/images/').'/'.$fimg->filename}}">
                        @endif
                    </td>
                    <td class="align-middle">
{{--                        <a target="_blank" href="{{//route('frontend_page', [$term_slug, $data->slug])}}">--}}
                        <a target="_blank" href="">
                            {{$data->name}}
                        </a>
                        <small class="d-block">/{{$data->term_type}}/{{$data->slug}}</small>
                    </td>
                    <td class="align-middle">
                        {{ !empty($data->category_id) ? $category::getCatByMultiid($data->category_id, 'name')  : '' }}
                    </td>
                    <td class="align-middle">{{$data->created_at}}</td>
                    <td class="align-middle">
                        <a href="{{route('backend_term_type_edit'.$term_slug, [$term_slug, $data->id])}}" class="badge alert-success"><i class="fa fa-edit"></i></a>
                        <a href="{{route('backend_term_type_delete'.$term_slug, [$term_slug, $data->id])}}" class="badge alert-danger" onclick="return confirm('Are you sure want to Delete?')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{$getPost->links('pagination::bootstrap-4')}}
        </div>

     </div>

@endsection

@section('content')
    <div class="card card-fluid">
        <div class="card-body py-1">
            <div class="table-responsive">
                <table id="example" class="table table-sm table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div id="dt_pageinfo"></div>
        </div>
        <!-- Databale Test -->
    </div>
@endsection

@section('cusjs')

    @include('backend.components.datatable')

    <script>
        let  arr = [
            { "data": "order_by", 'id' : '1'},
            { "data": "name" },
            { "data": "category"},
            { "data": "created_at"},
            { "data": "button"},
        ];
        loadDatatable(
            "#example", 
            "{{ route('backend_term_type_api_get'.$term_slug, $term_slug) }}", 
            arr, 
            {
                'sortable' : true,
                'route' : "{{ route('backend_term_type_updateorder'.$term_slug, $term_slug) }}",
            });


    </script>


@endsection
