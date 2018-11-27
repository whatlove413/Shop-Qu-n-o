<a 
    href        = "{!! $href or 'javascript:void(0)' !!}" 
    title       = "{!! $title !!}"
    
    @if ( isset($rel) )
        rel     = "{!! $rel !!}"
    @elseif ( !isset($href) )
        rel     = "nofollow"
    @endif

    @if ( isset($attrs) && is_array( $attrs ) )
        @foreach ($attrs as $attr => $value)
            {!! $attr !!}="{!! $value !!}"
        @endforeach
    @endif
>
    {!! $slot !!}
</a>