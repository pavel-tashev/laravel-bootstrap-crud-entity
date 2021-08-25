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
    public function index()
    {
    	$users = User::with(['roles'])->paginate($this->itemsPerPage);

		return view('users.index', compact('users'));
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
