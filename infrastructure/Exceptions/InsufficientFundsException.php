<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 7-12-2017
 * Time: 00:42
 */

namespace Infrastructure\Exceptions;

class InsufficientFundsException extends \Exception
{
	public function __construct()
	{
		parent::__construct("Account has insufficient funds.", 402);
	}

}