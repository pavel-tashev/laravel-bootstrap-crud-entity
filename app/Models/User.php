<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	use HasFactory;

	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

	/**
	 * The roles that belong to the user.
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Models\Role');
	}

	/**
	 * Attach roles to user.
	 *
	 * @param $roleIds
	 */
	public function assignRoles($roleIds)
	{
		foreach ($roleIds as $roleId)
		{
			$role = Role::findOrFail($roleId);
			$this->roles()->attach($role);
		}
	}

	/**
	 * Update the roles of the user.
	 *
	 * @param $roleIds
	 */
	public function updateRoles($roleIds)
	{
		$this->roles()->sync([]);
		$this->assignRoles($roleIds);
	}
}
