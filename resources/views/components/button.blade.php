@props(['url'=>'/',
        'icon' => null,
        'bg'=>'bg-yellow-500',
        'hover'=>'bg-yellow-600',
        'text'=>'text-black',
        'block'=> false])

<a href="{{$url}}" class="hover:{{$hover}} py-2 px-4 {{$bg}} {{$text}} rounded {{$block ? "block" : ''}}">
    
    @if($icon)
        <i class="fa fa-{{$icon}}"></i>
    @endif
    
    {{$slot}}
</a>