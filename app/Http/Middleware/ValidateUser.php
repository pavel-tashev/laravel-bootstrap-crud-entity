<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class ValidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$errors = new \Illuminate\Support\MessageBag();

    	// Check if the request is POST or PUT
		if ($request->isMethod('post') || $request->isMethod('put')) {
			do {
				// Check if the passed fields are empty
				if (!$request->filled(['name', 'email', 'roles'])) {
					$errors->add('missing_fields', 'All fields are required.');
					break;
				}

				// Check if the roles exist
				if (
					!is_array($request->roles) &&
					!(count($request->roles) == Role::whereIn('id', $request->roles)->get()->count())
				) {
					$errors->add('invalid_role', 'One or more of the selected roles do not exist.');
				}

				// Check if the email address is valid
				if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
					$errors->add('invalid_email', 'The email must be valid.');
					break;
				}

				// Check if the email address is occupied
				if ($request->isMethod('post') && !is_null(User::where('email', $request->email)->first())) {
					$errors->add('email_occupied', 'The email is already occupied.');
					break;
				}

				break;
			} while(0);
		}

		// Attach the errors
		$request->route()->setParameter('errors', $errors);

        return $next($request);
    }
}
