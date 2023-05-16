<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<ul class="pagination">
@if ($paginator->onFirstPage())
    <li class="disabled"><span>← Previous</span></li>
        @else
            <li>
                <a class="pgn__prev" href="{{ $paginator->withQueryString()->previousPageUrl() }}">Prev</a>
            </li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active my-active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li>
                <a class="pgn__next" href="{{ $paginator->withQueryString()->nextPageUrl() }}">Next</a>
            </li>
        @else
    <li class="disabled"><span>Next</span></li>
@endif
</ul>