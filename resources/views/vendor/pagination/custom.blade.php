@if ($paginator->hasPages())
    <ul class="pager">
      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a><li class="active my-active">{{ $page }}</li></a>
                    @else
                        <a href="{{ $url }}"><li>{{ $page }}</li></a>
                    @endif
                @endforeach
            @endif
        @endforeach   
        
    </ul>
@endif 