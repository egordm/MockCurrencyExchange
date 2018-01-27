<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 18-1-2018
 * Time: 20:45
 */

namespace App\Models;


use Eloquent;

/**
 * App\Models\BaseModel
 *
 * @mixin \Eloquent
 */
class BaseModel extends Eloquent
{
	public static function getTableName()
	{
		return with(new static)->getTable();
	}
}