@if ($field === $orderBy)
    @if ($orderAsc)
        <i class="fa fa-asc"></i>
    @else
        <i class="fa fa-desc"></i>
    @endif
@endif