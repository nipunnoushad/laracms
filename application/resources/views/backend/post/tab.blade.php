@php
    $customFieldTab = $Core::customFieldFile($term_slug);
@endphp
 @if(!empty($post))
    @if($customFieldTab)
    <div class="card align-items-center">
        <ul class="nav nav-pills">
            <li class="nav-item {{request()->get('custom-field') ?? 'bg-primary'}}">
                <a href="{{route('admin_term_type_edit', [$term_slug, $post->id])}}" class="btn btn-default btn-sm">{{$term_name}}</a>
            </li>
        @foreach($customFieldTab as $item)
            <li class="nav-item {{request()->get('custom-field') == $item['name'] ? 'bg-primary' : null}}">
                <a class="btn btn-default btn-sm" href="{{route('admin_term_type_edit', [$term_slug, $post->id])}}?custom-field={{$item['name']}}">
                    {{$item['title']}}
                </a>
            </li>
        @endforeach
        </ul>
    </div>
    @endif
@endif
