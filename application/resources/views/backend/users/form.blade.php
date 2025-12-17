@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())


@section('content')
@php
    //dd(array_search(4, array_column($user->roles->toArray(), 'role_id')));
@endphp

    <div class="row">
        <div class="col-md-8 col-lg-6 col-sm-12">
                <div class="card m-0" id="formModal">
                    <form action="{{ !empty($user) ? route('backend_user_update') : route('backend_user_store') }}" method="post">
                    @csrf
                    @if (!empty($user))
                        <input type="hidden" name="id" value="{{ $user->id }}">
                    @endif
                    <div class="card-body">

                        <div class="form-group name">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="name">
                                    <span class="input-group-text">Name</span>
                                </label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                                        value="{{ !empty($user) ? $user->name : old('name') }}" required>
                            </div>
                        </div>

                        <div class="form-group email">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="email">
                                    <span class="input-group-text">Email</span>
                                </label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                    placeholder="Enter email" name="email"
                                    value="{{ !empty($user) ? $user->email : old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="phone">
                                    <span class="input-group-text">Phone No</span>
                                </label>
                                <input type="number" class="form-control" id="phoneNumber" placeholder="Phone number"
                                    name="phone" value="{{ !empty($user) ? $user->phone : old('phone') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="employee_no">
                                    <span class="input-group-text">Employee No</span>
                                </label>
                                <input type="text" class="form-control" placeholder="Employee No" name="employee_no"
                                    value="{{ !empty($user) ? $user->employee_no : old('employee_no') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="address">
                                    <span class="input-group-text">Address</span>
                                </label>
                                <input type="text" class="form-control" placeholder="Enter Address" name="address"
                                    value="{{ !empty($user) ? $user->address : old('address') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="postcode">
                                    <span class="input-group-text">Post code</span>
                                </label>
                                <input type="text" class="form-control" placeholder="Enter post code" name="postcode"
                                    value="{{ !empty($user) ? $user->postcode : old('postcode') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="district">
                                    <span class="input-group-text">District</span>
                                </label>
                                <input type="text" class="form-control" placeholder="Enter District" name="district"
                                    value="{{ !empty($user) ? $user->district : old('district') }}">
                            </div>
                        </div>

                        <div class="form-group select arrow_class">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="gender">
                                    <span class="input-group-text">Gender </span>
                                </label>
                                @php
                                    $genders = [
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                    ];
                                @endphp
                                <select class="custom-select" name="gender">
                                    <option value="">Select gender</option>
                                    @foreach ($genders as $index => $gender)
                                        <option value="{{ $index }}"
                                            {{ !empty($user) && $user->gender == $index ? 'selected' : '' }}>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Select User Role --}}
                        <div class="form-group select arrow_class">
                            <div class="input-group input-group-alt">
                                <label class="input-group-prepend" for="role_id">
                                    <span class="input-group-text">Select Role</span>
                                </label>
                                @php
                                    $roles = $Query::getData('roles')->whereIn('type', ['Global','General']);
                                    $getExistingRoleUserColumnId = '';
                                @endphp
                                <select class="custom-select" aria-label=".form-select-lg" id="select" name="role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        @php
                                            if(!empty($user)){
                                                $user_role =  $user->roles->toArray();
                                            }else {
                                                $user_role = [];
                                            }
                                            $getMatchedRoleIdArr = array_search($role->id, array_column($user_role, 'role_id'));
                                            $getRoleId = $user->roles[$getMatchedRoleIdArr] ?? null;
                                            $userRoleId= $getRoleId->role_id ?? null;
                                            $getExistingRoleUserColumnId = $getRoleId->id ?? null;
                                        @endphp
                                        <option value="{{ $role->id }}"
                                            {{ $userRoleId === $role->id ? 'selected' : ''}}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="role_user_id" value="{{$getExistingRoleUserColumnId ?? Null}}" />
                            </div>
                        </div>
                        {{-- End User Role --}}
                        <div class="form-submit_btn">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>
                </div>
            </div>
    </div>

@endsection
