<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$users = User::all();

		return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
	{
		return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
		$user = User::create($request->all());

		return redirect('/users/'.$user->id);
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
		return view('users.edit', compact('user'));
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
		$user->update($request->all());

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
