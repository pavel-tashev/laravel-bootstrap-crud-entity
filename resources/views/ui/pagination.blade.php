@if ($data->lastPage() > 1)
    {{-- Define the first and the last page number we are going to display in the pagination. --}}
	<?php
        $spread = 5;
        $current_page = $data->currentPage();
	    $last_page = $data->lastPage();

        $left_page = $current_page - $spread < 1 ? 1 : $current_page - $spread;
        $right_page = $current_page + $spread > $last_page ? $last_page : $current_page + $spread;
	?>

    <div class="d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                {{-- First and Previous buttons --}}
                <li class="page-item {{ ($data->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $data->url(1) }}">First</a>
                </li>
                <li class="page-item {{ ($data->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $data->previousPageUrl() }}">
                        <span aria-hidden="true">&laquo;</span> Previous
                    </a>
                </li>

                {{-- Display page buttons from left to right page where the current page is in between. --}}
                @for ($i = $left_page; $i <= $right_page; $i++)
                    @if ($data->currentPage() == $i)
                        <li class="page-item active">
                            <span class="page-link">{{ $i }}<span class="sr-only">(current)</span></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Display the last page button giving an idea of how many pages are left. --}}
                @if ($right_page < $last_page)
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->url($last_page) }}">{{ $last_page }}</a>
                    </li>
                @endif

                {{-- Next and Last buttons --}}
                <li class="page-item {{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $data->nextPageUrl() }}">
                        Next <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item {{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $data->url($data->lastPage()) }}">Last</a>
                </li>
            </ul>
        </nav>
    </div>
@endif