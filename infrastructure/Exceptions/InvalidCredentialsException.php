<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 22:34
 */

namespace Infrastructure\Exceptions;


use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class InvalidCredentialsException extends UnauthorizedHttpException
{
	public function __construct($message = null, \Exception $previous = null, $code = 0)
	{
		parent::__construct('You have entered invalid credentials.', $message, $previous, $code);
	}
}