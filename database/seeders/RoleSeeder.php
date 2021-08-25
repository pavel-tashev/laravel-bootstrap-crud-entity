<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('roles')->insert([
			'id'   => 1,
			'name' => "Administrator",
			'slug' => "ADMIN"
		]);

		DB::table('roles')->insert([
			'id'   => 2,
			'name' => "Moderator",
			'slug' => "MODERATOR"
		]);

		DB::table('roles')->insert([
			'id'   => 3,
			'name' => "Editor",
			'slug' => "EDITOR"
		]);

		DB::table('roles')->insert([
			'id'   => 4,
			'name' => "Customer",
			'slug' => "CUSTOMER"
		]);
    }
}