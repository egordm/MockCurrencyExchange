<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 14:12
 */

namespace Infrastructure\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;
use Request;
use Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

trait RestExceptionHandlerTrait
{
	/**
	 * Creates a new JSON response based on exception type.
	 *
	 * @param Request $request
	 * @param \Throwable $e
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function getJsonResponseForException($request, \Exception $e)
	{
		if($this->isHttpException($e) && $e->getCode() < 600) return $this->jsonException($e->getMessage(), $e->getCode());
		if ($e instanceof AuthenticationException) return $this->jsonException($e->getMessage(),401);
		if ($e instanceof ValidationException || $e instanceof ValidatorException) return $this->validationException($e);
		if($e instanceof ResourceNotFoundException || $e instanceof NotFoundHttpException ||$e instanceof ModelNotFoundException)
			return $this->notFoundExeption($e);

		return $this->jsonException($e->getMessage(), 400);
	}

	protected function validationException($exception)
	{
		$errors = method_exists($exception,'errors') ? $exception->errors() : $exception->getMessageBag();
		return $this->jsonException($errors, 400);
	}

	protected function notFoundExeption($exception)
	{
		return $this->jsonException($exception->getMessage(), 404);
	}

	public function jsonException($message, $code=400)
	{
		return Response::json([
			'success' => false,
			'message' => !empty($message) ? $message : 'Resource could not be found!'
		], $code);
	}

	protected function isHttpException(\Exception $e)
	{
		return $e instanceof \HttpException;
	}
}