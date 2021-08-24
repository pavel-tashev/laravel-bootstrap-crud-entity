<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureEntityExists
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
    	$entities = $request->route()->parameters();

    	// Check if a particular entity has been passed
    	if (array_key_exists('user', $entities)) {
			$user = User::find($entities['user']);

			// Check if the user exists and if not, redirect to the list of users
			if (is_null($user)) return redirect('/users');

			// Pass the entity object to the controller
			$request->route()->setParameter('user', $user);
		}

        return $next($request);
    }
}
