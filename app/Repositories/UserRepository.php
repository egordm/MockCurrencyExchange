<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 22:28
 */

namespace App\Repositories;


use App\User;
use Bosnadev\Repositories\Eloquent\Repository;

class UserRepository extends Repository
{

	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	public function model()
	{
		return User::class;
	}
}