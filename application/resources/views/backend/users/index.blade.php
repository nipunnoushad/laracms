@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())

@section('content-filter')
    <div id="dt_filter"></div>
@endsection

@section('content')

<div class="card card-fluid">
    <div class="card-body py-1">
        <div class="table-responsive">
            <table id="example" class="table table-sm table-hover" style="width:100%">

            </table>
        </div>
        <div id="dt_pageinfo"></div>
    </div>
    <!-- Databale Test -->
</div>

<button type="button" data-toggle="modal" data-target="#modalTable" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button>

@endsection


@section('cusjs')

    @include('backend.components.datatable')

    <script>
        let arr = [
            {"title" : "Name",  "data" : 'name'},
            {"title" : "Email", "data" : 'email'},
            {"title" : "Employee_no", "data" : 'employee_no'},
            {"title" : "Phone", "data" : 'phone'},
            {"title" : "Employee Status", "data" : 'employee_status'},
            {"title" : "Roles", "data" : 'roles'},
            {"title" : "Acction" ,"data" : "button"},
        ];

        loadDatatable("#example", "{{ route('backend_user_api_getuser') }}", arr);
    </script>

    @include('backend.components.modal', $options = [
        'id' => 'modalTable',
        'ajax_url' => route('backend_user_create').' #formModal',
        'ajax_method' => 'GET',
        'title' => 'Add new user'
    ])

@endsection
