<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class User extends Model
{
	use HasFactory, Sortable;

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


	public $sortable = [
		'name',
		'email'
	];

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
