@props(['url'=>'/',
        'active'=>false,
        'icon' => null,
        'text'=>'text-white',
        'textActive'=>'text-yellow-500',
        'mobile'=> null
        ])

@if($mobile)

<a href="{{$url}}" class="block px-4 py-2 hover:bg-blue-700
     {{$active ? $textActive: ''}}
     {{$active ? "font-bold": ''}}"
     >
     
     @if($icon)
     <i class="fa fa-{{$icon}}"></i>
    @endif

     {{$slot}}
     
     </a>

@else

<a href="{{$url}}" class="{{$text}} hover:underline py-2 {{$active ? $textActive: ''}}
         {{$active ? "font-bold": ''}}">
    
    @if($icon)
        <i class="fa fa-{{$icon}}"></i>
    @endif
    
    {{$slot}}
</a>

@endif