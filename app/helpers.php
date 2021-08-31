<?php

use Illuminate\Http\Request;

if (! function_exists('validateSortAndPagination')) {
	function validateSortAndPagination(Request $request, array $sort_allowed, array $direction_allowed)
	{
		$page      = 1*$request->page ?? 1;
		$sort      = $request->sort ?? null;
		$direction = $request->direction ?? null;

		if (!in_array($sort, $sort_allowed)) $sort = null;
		if (!in_array($direction, $direction_allowed)) $direction = null;
		if (!is_int($page)) $page = 1;

		return [$page, $sort, $direction];
	}
}
