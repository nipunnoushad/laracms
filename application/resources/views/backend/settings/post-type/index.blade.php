@extends('backend.layouts.master')

@section('title', $Model('Routelist')::title())
@section('page-title', $Model('Routelist')::title())

@section('content')
<div class="row">
    <div class="col-lg-6"><!-- form -->
        <form action="{{route('backend_setings_posttype_taxonomy_store')}}" method="post">
            @csrf
            <div class="card card-fluid">
            <div class="card-body">
                <fieldset>
                    <legend class="mb-2">Post Type</legend>
                    <div class="form-group">
                        <div class="input-group input-group-alt">
                            <label class="input-group-prepend" for="name">
                                <span class="input-group-text">Name</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                                   value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-group-alt">
                            <label class="input-group-prepend" for="slug">
                                <span class="input-group-text">Slug</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Slug" name="slug"
                                   value="" required>
                        </div>
                        <div class="form-text text-muted"> Slug name must be unique. </div>
                    </div>

                </fieldset>
            </div>

            <div class="card-body border-top">
                <fieldset>
                    <legend class="mb-2 p-0 list-group-item sd-flex justify-content-between align-items-center">
                        Taxonomy
                        <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="onoffswitch" class="switcher-input" >
                            <span class="switcher-indicator"></span>
                        </label>
                    </legend>
                    <div class="taxonomy_wrap">

                    </div>
                </fieldset>
            </div>
            <div class="form-submit_btn p-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div><!-- end col-->

    <div class="col-lg-6"><!-- content-->

    </div><!-- End Col-->
</div>

<script type="text/template" id="taxonomy_template">
    <div class="form-group">
        <div class="input-group input-group-alt">
            <label class="input-group-prepend" for="name">
                <span class="input-group-text">Name</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                   value="" required>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group input-group-alt">
            <label class="input-group-prepend" for="slug">
                <span class="input-group-text">Slug</span>
            </label>
            <input type="text" class="form-control" id="name" placeholder="Enter Slug" name="slug"
                   value="" required>
        </div>
        <div class="form-text text-muted"> Slug name must be unique. </div>
    </div>
</script>

@endsection

@section('cusjs')
    <script>
        let switcher_input = document.querySelector('.switcher-input');
            taxonomy_template= document.querySelector('script#taxonomy_template').innerHTML;
            taxonomy_wrap = document.querySelector('.taxonomy_wrap')
        switcher_input.addEventListener('click', function (){
            if(switcher_input.checked){
                taxonomy_wrap.innerHTML=taxonomy_template
            }else {
                taxonomy_wrap.innerHTML=null
            }
        })
    </script>
@endsection
