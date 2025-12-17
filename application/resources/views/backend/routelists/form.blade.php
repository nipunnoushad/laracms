@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6 col-sm-12">
            <div class="card m-0" id="formModal">
                <form action="{{ !empty($routelist) ? route('backend_routelist_update') : route('backend_routelist_store') }}" method="post">
                @csrf
                @if (!empty($routelist))
                    <input type="hidden" name="id" value="{{ $routelist->id }}">
                @endif

                    <div class="card-body">
                        <div class="form-group name">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="route_title">
                                    <span class="input-group-text">Route title</span>
                                </label>
                                <input type="text" class="form-control" placeholder="Enter route title" name="route_title"
                                       value="{{ !empty($routelist) ? $routelist->route_title : old('route_title') }}" required>
                            </div>
                        </div>

                        <div class="form-group email">
                            <div class="input-group input-group-alt">
                                    <label class="input-group-prepend" for="route_title">
                                        <span class="input-group-text">Route name</span>
                                    </label>
                                <input type="text" class="form-control" placeholder="Enter route name" name="route_name"
                                    value="{{ !empty($routelist) ? $routelist->route_name : old('route_name') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="route_group">
                                    <span class="input-group-text">Route group </span>
                                </label>
                                @php
                                    $routeGroup = $Query::getData('route_groups');
                                @endphp
                                 <select class="custom-select" name="route_group">
                                    <option value="">Select one</option>
                                    @foreach($routeGroup as $index => $group)
                                    <option value={{$group->id}}
                                        {{ !empty($routelist) && $routelist->route_group == $group->id ? 'selected' : '' }}>{{$group->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-label-group">
                                <textarea required class="form-control py-4 h-auto"
                                          name="route_description">{{ !empty($routelist) ? $routelist->route_description : old('route_description') }}</textarea>
                                <label>
                                    <span class="input-group-text border-0 shadow-none p-0 text-muted">Route Description</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="route_icon">
                                    <span class="input-group-text">Route icon</span>
                                </label>
                            <input type="text" class="form-control" placeholder="Route icon" name="route_icon"
                                value="{{ !empty($routelist) ? $routelist->route_icon : old('route_icon') }}">
                            </div>
                        </div>
                        <?php /*
                        <div class="form-group">
                            <div class="input-group input-group-alt" for="route_order">
                            <label class="input-group-prepend">
                               <span class="input-group-text"> Route order</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Route Order" name="route_order"
                                value="{{ !empty($routelist) ? $routelist->route_order : old('route_order') }}">
                            </div>
                        </div>
                        */ ?>
                        <div class="form-group select arrow_class">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="select">
                                    <span class="input-group-text">Show in menu </span>
                                </label>
                                <select class="custom-select" name="show_menu" aria-label=".form-select-lg" id="show_menu">
                                    <option value="">Select one</option>
                                    <option value="Yes"
                                        {{ !empty($routelist) && $routelist->show_menu == 'Yes' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="No"
                                        {{ !empty($routelist) && $routelist->show_menu == 'No' ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- dashboard Menu position -->
                        <div class="form-group">
                            <label class="d-block" for="">Dashboard menu position</label>
                                @php
                                    $menuPosition = ['Left', 'Right', 'Top', 'Bottom'];
                                @endphp
                                @foreach($menuPosition as  $value)
                                <div class="custom-control custom-control-inline custom-checkbox">
                                    <input type="checkbox" id="routelist_index_{{$value}}" class="custom-control-input" name="dashboard_position[]" value="{{$value}}" {{!empty($routelist) && strstr($routelist->dashboard_position, $value) ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="routelist_index_{{$value}}">{{$value}}</label>
                                </div>
                                @endforeach
                        </div>
                        <!-- End Dahboard Menu Position -->

                        <div class="form-submit_btn">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
