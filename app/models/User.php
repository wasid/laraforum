<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public function getRemberToken(){

		return $this->remember_token;
	}

	public function setRemberToken(){

		$this->remember_token = $remember_token;
	}

	public function setRemberTokenName(){

		return 'remember_token';
	}

	public function isAdmin(){

		return ($this->isAdmin == 1);

	}

}
