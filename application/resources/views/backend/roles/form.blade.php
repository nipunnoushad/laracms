@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())

@section('content')
    <form action="{{ !empty($role) ? route('backend_role_update') : route('backend_role_store') }}" method="post" id="formModal">
        @csrf
        <div class="row">
            <div class="col-md-8 col-lg-4 col-sm-12">
                <div class="card card-fluid">
                    <div class="card-header">
                        Role Information
                    </div>
                    <div class="card-body">
                        @if (!empty($role))
                            <input type="hidden" name="id" value="{{ $role->id }}">
                        @endif
                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="name">
                                    <span class="input-group-text">Role Name</span>
                                </label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                                       value="{{ !empty($role) ? $role->name : old('name') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                @php
                                    $role_type = [
                                        'Global' => 'Global',
                                        'General' => 'General',
                                        'Custom' => 'Custom',
                                    ];
                                @endphp
                                <label class="input-group-prepend" for="type">
                                    <span class="input-group-text">Role type</span>
                                </label>
                                <select class="custom-select" name="type" id="type">
                                    <option>Select role type</option>
                                    @foreach ($role_type as $index => $data)
                                        <option value="{{ $index }}"
                                            {{ !empty($role) && $role->type == $index ? 'selected' : '' }}>
                                            {{ $data }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-8 col-lg-7 col-sm-12">
                <div class="card card-fluid">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <span class="mr-auto">Route Permission</span>
                            <input type="checkbox" class="" id="checkAll">
                            <label for="checkAll" class="mb-0 ml-1">Check All</label>
                        </div>
                    </div>

                    <div class="card-body">
                        @php
                            $routeList = $Query::getData('route_lists')->groupBy('route_group');
                            //dd($routeList);
                        @endphp
                        <div class="row xd-block" xdata-masonry='{"percentPosition": true }'>
                            @foreach ($routeList as $index => $item)
                                <div class="col-md-4">
                                    <div class="xform-group">
                                        <div class="form-check">
                                            <p class="mb-1 fw-bold">
                                                {{ $Model('Routegroup')::name($index) }}
                                            </p>
                                            @foreach ($item as $key => $data)
                                                @php
                                                    $checkId = \App\Models\Routelistrole::checkRouteRole($role->id ?? null, $data->id);

                                                    $routeid = $checkId->route_id ?? null;
                                                    $showAs = $checkId->show_as ?? null;
                                                    //dump( $showAs);
                                                @endphp
                                                <div class="form-group {{ !empty($data->show_for) ? 'alert-success ps-1' : '' }}">
                                                    <input type="checkbox" id="{{ $data->route_name }}"
                                                        class=" mb-0 checkItem route_name"
                                                        {{ $routeid == $data->id ? 'checked' : '' }} name="route_id[]"
                                                        value="{{ $data->id }}">
                                                    <label class=" route_name"
                                                        for="{{ $data->route_name }}">{{ $data->route_title }}</label>
                                                </div>

                                                @if ($data->is_show_as == 'Yes')
                                                    <div class="form-group ms-3 ps-2 alert-warning  {{ $data->route_name . '_show_as' }}"
                                                        style="{{ $showAs ? '' : 'display: none' }}">
                                                        <label class="" for="">Show Based On</label>
                                                    </div>
                                                    <div class="form-group ms-3 ps-2 alert-warning {{ $data->route_name . '_show_as' }}"
                                                        style="{{ $showAs ? 'display:block' : 'display: none' }}">
                                                        @php $showAsEnum = $Query::getEnumValues('route_list_roles', 'show_as'); @endphp
                                                        @foreach ($showAsEnum as $value)
                                                            <div class="d-inline-flex">
                                                                <input type="radio" id="{{ $data->id . $value }}"
                                                                    class="checkItem mb-0"
                                                                    {{ $showAs == $value ? 'checked' : '' }}
                                                                    name="show_as[{{ $data->id }}]"
                                                                    value="{{ $value }}">
                                                                <label class="w-100"
                                                                    for="{{ $data->id . $value }}">{{ $value }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- Card Body -->
                </div>
            </div>

        </div>
    </form>
@endsection

@section('cusjs')
    @include('backend.roles.js')
@endsection
