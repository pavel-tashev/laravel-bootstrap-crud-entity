@if (($direction != 'asc' && $sort == $sort_current) || $sort != $sort_current)
    <a href="{{$path}}?sort={{$sort}}&direction=asc">
        <i class="fa fa-arrow-down"></i>
    </a>
@endif

@if (($direction != 'desc' && $sort == $sort_current) || $sort != $sort_current)
    <a href="{{$path}}?sort={{$sort}}&direction=desc">
        <i class="fa fa-arrow-up"></i>
    </a>
@endif