@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())

@section('content')

<div class="card card-fluid">
    <div class="card-body py-1">
      <!-- .form-group -->
      <!-- /.form-group -->
      <!-- .table-responsive -->

      <div class="table-responsive">
        <!-- .table -->
        <table class="table table-sm table-hover mb-0">
          <!-- thead -->
          <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
          </thead><!-- /thead -->
          <!-- tbody -->
          <tbody>
            <!-- tr -->
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->code }}</td>
                    <td>{{ $role->type }}</td>
                    <td>
                        {!! $ButtonSet::edit('backend_role_edit', $role->id) !!}
                        {!! $ButtonSet::delete('backend_role_destroy', $role->id) !!}
                    </td>
                </tr>
            @endforeach
          </tbody><!-- /tbody -->
        </table><!-- /.table -->
      </div><!-- /.table-responsive -->
      <!-- .pagination -->
      <!-- /.pagination -->
    </div><!-- /.card-body -->
</div>
@if(auth()->user()->hasRoutePermission('backend_role_create'))
    <button type="button" data-toggle="modal" data-target="#modalTable" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button>
@endif
@endsection


@section('cusjs')
    @include('backend.components.modal', $options = [
       'id' => 'modalTable',
       'ajax_url' => route('backend_role_create').' #formModal',
       'ajax_method' => 'GET',
       'title' => 'Add new role',
       'modal_size' => 'xl'
   ])
    @include('backend.roles.js')
@endsection
