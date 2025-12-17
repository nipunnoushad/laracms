@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())


@section('content-filter')

@endsection

@section('content')

<div class="card card-fluid">
    <div class="card-body py-1">
         <div id="dt_filter" class="my-2"></div>
        <div class="table-responsive">
            <table id="example" class="table table-sm table-hover" style="width:100%">
             <thead>
                <tr>
                    <th>S/N</th>
                    <th>Route Title</th>
                    <th>Route Name</th>
                    <th>Route Group</th>
                    <th>Route Description</th>
                    <th>Show in menu</th>
                    <th>Dashboard Menu</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        </div>
        <div id="dt_pageinfo"></div>
    </div>
    <!-- Databale Test -->
</div>

<button type="button" data-toggle="modal" data-target="#modalTable" class="btn btn-primary btn-floated"><span class="fa fa-plus"></span></button>

@endsection

@section('cusjs')

@include('backend.components.datatable')

<script>
    let  arr = [
        { "data": "route_order"},
        { "data": "route_title"},
        { "data": "route_name" },
        { "data": "route_group"},
        { "data": "route_description"},
        { "data": "show_menu"},
        { "data": "dashboard_position"},
        { "data": "created_at"},
        { "data": "button"},
    ];
    loadDatatable(
        "#example",
        "{{ route('backend_routelist_api_get') }}",
        arr,
        {
            'sortable' : true,
            'route' : "{{ route('backend_routelist_updateorder') }}"
        }
    );


</script>


    @include('backend.components.modal', $options = [
        'id' => 'modalTable',
        'ajax_url' => route('backend_routelist_create').' #formModal',
        'ajax_method' => 'GET',
        'title' => 'Add new route'
    ])

@endsection


