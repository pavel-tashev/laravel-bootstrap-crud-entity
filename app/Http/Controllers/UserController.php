<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
	private $itemsPerPage      = 10;
	private $sort_allowed      = ['email', 'name'];
	private $direction_allowed = ['desc', 'asc'];

	/**
	 * Instantiate a new UserController instance.
	 */
	public function __construct() {
		$this->container   = Container::getInstance();
		$this->viewFactory = $this->container->make(ViewFactory::class);
	}

    /**
     * Display a listing of the resource.
     *
	 * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	// Validate and get the parameters responsible for the sorting and the pagination using a custom helper
		list($page, $sort, $direction) =
			validateSortAndPagination($request, $this->sort_allowed, $this->direction_allowed);

		// Prepare to get a list of users
		$users = new User();

		// Count users and calculate the pages
		$pages = ceil($users->get()->count()/$this->itemsPerPage);

		// Sort users
		if (!is_null($sort) && !is_null($direction)) $users = $users->orderBy($sort, $direction);

		// Get users
		$users = $users
			->offset($this->itemsPerPage * ($page - 1))
			->limit($this->itemsPerPage)
			->with(['roles'])
			->get();

		// Rend the view
		return $this->viewFactory->make('users.index', [
			'users'     => $users,
			'page'      => $page,
			'sort'      => $sort,
			'direction' => $direction,
			'pages'     => $pages
		]);
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
		if ('POST' === $request->getMethod() && $errors->count() == 0) {
			$user = new User();
			$user = $user->create([
				'name'  => $request->name,
				'email' => $request->email
			]);
			$user->assignRoles($request->roles);

			return redirect('/users/'.$user->id.'/edit');
		}

		$roles = new Role();

		// Rend the view
		return $this->viewFactory->make('users.create', [
			'roles'          => $roles->all(),
			'errors'         => $errors,
			'name'           => $request->name ?? '',
			'email'          => $request->email ?? '',
			'roles_selected' => $request->roles ?? []
		]);
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
		if ('PUT' === $request->getMethod() && $errors->count() == 0) {
			$user->update([
				'name'  => $request->name,
				'email' => $request->email
			]);
			$user->updateRoles($request->roles);
		}

		$roles = new Role();

		// Rend the view
		return $this->viewFactory->make('users.edit', [
			'user'   => $user,
			'roles'  => $roles->all(),
			'errors' => $errors
		]);
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

		return $this->container->make('redirect')->to("/users", 302, [], null);
    }
}
