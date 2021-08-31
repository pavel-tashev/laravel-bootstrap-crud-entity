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
	 * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	// Validate the input data
		$errors = new \Illuminate\Support\MessageBag();
		if ($request->has('sort') && !in_array($request->sort, ['email', 'name'])) {
			$request->request->remove('sort');
		}
		if ($request->has('direction') && !in_array($request->direction, ['desc', 'asc'])) {
			$request->request->remove('direction');
		}
		if ($request->has('page') && !is_int(1*$request->page)) {
			$request->request->remove('page');
		}

		// Set parameters
		$page = isset($request->page) ? $request->page : 1;
		$sort = isset($request->sort) ? $request->sort : null;
		$direction = isset($request->direction) ? $request->direction : null;

		// Prepare to get users
		$users = new User();
		$users = $users->with(['roles']);

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
	 * @param Request $request
	 * @param $errors
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $errors)
	{
		// Create the user if there are no errors after the validation (by the Middleware attached to the router)
		if ($request->isMethod('post') && !$errors->any()) {
			$user = new User();
			$user = $user->create([
				'name' => $request->name,
				'email' => $request->email
			]);
			$user->assignRoles($request->roles);

			return redirect('/users/'.$user->id.'/edit');
		}

		// Define parameters that will be displayed in the view
		$roles = new Role();
		$roles = $roles->all();
		$name = $request->has('name') ? $request->name : '';
		$email = $request->has('email') ? $request->email : '';
		$roles_selected = $request->has('roles') ? $request->roles : [];

		return view('users.create', compact(['roles', 'errors', 'name', 'email', 'roles_selected']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
	 * @param $user
	 * @param $errors
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $user, $errors)
    {
		// Update the user if there are no errors after the validation (by the Middleware attached to the router)
		if ($request->isMethod('put') && !$errors->any()) {
			$user->update([
				'name' => $request->name,
				'email' => $request->email
			]);
			$user->updateRoles($request->roles);
		}

		// Define parameters that will be displayed in the view
		$roles = new Role();
		$roles = $roles->all();

		return view('users.edit', compact(['user', 'roles', 'errors']));
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
