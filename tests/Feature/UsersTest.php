<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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
	 * Test the reading of a single user.
	 *
	 * @return void
	 */
	public function test_read_single_user()
	{
		// Create and store a new user in the database
		$user = User::factory()->create();

		// Get the user by id
		$response = $this->get('/users/' . $user->id);

		// Check if the response contains the created user
		$response->assertSee($user->name);
	}

	/**
	 * Test the reading of a single nonexistent user.
	 *
	 * @return void
	 */
	public function test_read_single_nonexistent_user()
	{
		// Get a user with a wrong id
		$response = $this->get("/users/" . (string) rand(10, 20));

		// Check if we are redirected back to the list of users
		$response->assertStatus(302);
	}

	/**
	 * Create a new user.
	 *
	 * @return void
	 */
	public function test_create_new_user()
	{
		// Create a new user (instance of the User model)
		$user = User::factory()->make();

		// Submit a post request to store the user in the database
		$this->post('/users', $user->toArray());

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
		// Create and store a new user in the database
		$user = User::factory()->create();

		// Update the user's name
		$user->name = "New name";

		// Submit a put request to update the user
		$this->put('/users/'.$user->id, $user->toArray());

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
		$response = $this->put("/users/" . (string) rand(10, 20), $user->toArray());

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