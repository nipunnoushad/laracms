<?php
$default = [
    'id' => 'modalID',
    'ajax_url' => '',
    'ajax_method' => 'GET',
    'title' => '',
    'footer' => false,
    'modal_size' => 'lg'
];
$merge = array_merge($default, $options ?? []);

?>
<div class="modal fade has-shown" id="{{$merge['id']}}" tabindex="-1" role="dialog" aria-labelledby="modalTableLabel" aria-hidden="true">
    <div class="modal-dialog modal-{{$merge['modal_size']}}" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h6 id="modalTableLabel" class="modal-title">
                    {{$merge['title']}}
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0 {{$merge['id']}}_modal_body">

            </div>
            @if($merge['footer'])
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($){
        $('.{{$merge['id']}}_modal_body').load("{{$merge['ajax_url']}}");
    })
</script>

