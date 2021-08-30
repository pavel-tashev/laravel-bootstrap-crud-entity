@if ($pages > 1)
    {{-- Define the first and the last page number we are going to display in the pagination. --}}
	<?php
            // Calculate the left and the right page
            $spread = 5;
            $left_page = $page - $spread < 1 ? 1 : $page - $spread;
            $right_page = $page + $spread > $pages ? $pages : $page + $spread;

            // Prepare a string of parameters that will be attached to the url
	        $params = array_diff($params, [null]);
	        array_walk($params, function(&$value, $key) { $value = "$key=$value"; });
            $params = implode("&", $params);
	?>

    <div class="d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                {{-- First and Previous buttons --}}
                <li class="page-item {{ ($page == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{$path . '?page=1&' . $params}}">First</a>
                </li>
                <li class="page-item {{ ($page == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{$path . '?page=' . ($page - 1) . '&' . $params}}">
                        <span aria-hidden="true">&laquo;</span> Previous
                    </a>
                </li>

                {{-- Display page buttons from left to right page where the current page is in between. --}}
                @for ($i = $left_page; $i <= $right_page; $i++)
                    @if ($page == $i)
                        <li class="page-item active">
                            <span class="page-link">{{ $i }}<span class="sr-only">(current)</span></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{$path . '?page=' . $i . '&' . $params}}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Display the last page button giving an idea of how many pages are left. --}}
                @if ($right_page < $pages)
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{$path . '?page=' . $pages . '&' . $params}}">{{ $pages }}</a>
                    </li>
                @endif

                {{-- Next and Last buttons --}}
                <li class="page-item {{ ($page == $pages) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{$path . '?page=' . ($page + 1) . '&' . $params}}">
                        Next <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item {{ ($page == $pages) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{$path . '?page=' . $pages . '&' . $params}}">Last</a>
                </li>
            </ul>
        </nav>
    </div>
@endif