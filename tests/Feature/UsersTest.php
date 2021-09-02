<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test the listing of the users.
	 *
	 * @return void
	 */
	public function test_list_all_users()
	{
		// Create and store a new user in the database
		$user = User::factory()->create();

		// Get the list of all users
		$response = $this->get('/users');

		// Check if the list contains the created user
		$response->assertSee($user->name);
	}

	/**
	 * Create a new user.
	 *
	 * @return void
	 */
	public function test_create_new_user()
	{
		// Create and store a new role in the database
		$role = Role::factory()->create();

		// Create a new user (instance of the User model) and set roles
		$user = User::factory()->make();
		$user->roles[] = $role->id;

		// Submit a post request to store the user in the database
		$this->post('/users/create', $user->toArray());

		// Check if it's stored in the database
		$this->assertEquals(1, User::all()->count());
	}

	/**
	 * Start editing a nonexistent user.
	 *
	 * @return void
	 */
	public function test_edit_nonexistent_user()
	{
		// Request edit page in order to edit a user but with a wrong id
		$response = $this->get("/users/" . (string) rand(10, 20) . "/edit");

		// Check if we are redirected back to the list of users
		$response->assertStatus(302);
	}

	/**
	 * Update a user.
	 *
	 * @return void
	 */
	public function test_update_user()
	{
		// Create and store a new role in the database
		$role = Role::factory()->create();

		// Create and store a new user in the database, and set roles and a new name
		$user = User::factory()->create();
		$user->roles[] = $role->id;
		$user->name = "New name";

		// Submit a put request to update the user
		$this->put('/users/'.$user->id.'/edit', $user->toArray());

		// Check if the user has been updated
		$this->assertDatabaseHas('users',['id'=> $user->id , 'name' => 'New name']);
	}

	/**
	 * Update a nonexistent user.
	 *
	 * @return void
	 */
	public function test_update_nonexistent_user()
	{
		// Create and store a new user in the database
		$user = User::factory()->create();

		// Request update of a user but with a wrong id
		$response = $this->put("/users/" . (string) rand(10, 20).'/edit', $user->toArray());

		// Check if we are redirected back to the list of users
		$response->assertStatus(302);
	}

	/**
	 * Delete a user.
	 *
	 * @return void
	 */
	public function test_delete_user()
	{
		// Create and store a new user in the database
		$user = User::factory()->create();

		// Submit a delete request to delete the user
		$this->delete('/users/'.$user->id);

		// Check if the user has been deleted
		$this->assertDatabaseMissing('users',['id'=> $user->id]);
	}

	/**
	 * Delete a nonexistent user.
	 *
	 * @return void
	 */
	public function test_delete_nonexistent_user()
	{
		// Submit a delete request to delete a nonexistent user
		$response = $this->delete("/users/" . (string) rand(10, 20));

		// Check if we are redirected back to the list of users
		$response->assertStatus(302);
	}
}