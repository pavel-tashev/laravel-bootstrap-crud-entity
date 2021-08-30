<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
	private $itemsPerPage = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	// Validate
		$request->validate([
			'sort' => 'in:email,name',
			'direction' => 'in:desc,asc',
			'page' => 'integer'
		]);

		// Set parameters
		$page = isset($request->page) ? $request->page : 1;
		$sort = isset($request->sort) ? $request->sort : null;
		$direction = isset($request->direction) ? $request->direction : null;

		// Prepare to get users
		$users = User::with(['roles']);

		// Sort users
		if (!is_null($sort) && !is_null($direction)) $users = $users->orderBy($sort, $direction);

		// Count users and calculate the pages
		$pages = ceil($users->get()->count()/$this->itemsPerPage);

		// Get users
		$users = $users
			->offset($this->itemsPerPage * ($page - 1))
			->limit($this->itemsPerPage)
			->get();

		return view('users.index', compact(['users', 'page', 'sort', 'direction', 'pages']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
	{
		$roles = Role::all();

		return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
		$validatedData = $request->validate([
			'name' => 'required',
			'email' => 'required',
			'roles' => 'required',
		]);
		$user = User::create($validatedData);
		$user->assignRoles($request->roles);

		return redirect('/users/'.$user->id)->withInput();
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return \Illuminate\Http\Response
	 */
    public function show($user)
    {
		return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
		$roles = Role::all();

		return view('users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $user)
    {
		$validatedData = $request->validate([
			'name' => 'required',
			'email' => 'required',
			'roles' => 'required',
		]);
		$user->update($validatedData);
		$user->updateRoles($request->roles);

		return redirect('/users/'.$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
	 * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($user)
    {
    	$user->delete();

		return redirect("/users");
    }
}
