@if ($paginator->lastPage() > 1)
    <?php echo $paginator->currentPage() ?>
<nav>
    <ul class="pagination">

        <li data-page="1" class="page-item page-class {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" aria-disabled="true" aria-label="Next »">
            <a  class="page-link" href="{{ $paginator->url($paginator->currentPage()-1) }}">‹</a>
        </li>


        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li data-page="{{$i}}" class="page-item page-class {{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a></li>
        @endfor

        <li data-page="{{$paginator->currentPage()}}" class="page-item page-class {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" aria-disabled="true" aria-label="Next »">
        <a  class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}">›</a>
        </li>
    </ul>
</nav>

@endif


