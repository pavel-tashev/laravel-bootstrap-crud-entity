<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();

        // Get all users and loop them one by one by using roles. For each role_user relationship we attach
		// a role to the user. We attach one role by id.
        User::all()->each(function($user) use ($roles) {
        	$user->roles()->attach(
        		$roles->random(2)
			);
		});
    }
}
