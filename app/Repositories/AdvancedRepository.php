<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 6-12-2017
 * Time: 20:45
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Validator\Contracts\ValidatorInterface;

abstract class AdvancedRepository extends PresentableRepository
{
	/**
	 * Save a new entity in repository
	 *
	 * @param array $attributes
	 * @param array $guarded_attributes
	 * @return \Illuminate\Database\Eloquent\Model
	 * @throws \Prettus\Validator\Exceptions\ValidatorException
	 */
	public function createInstance(array $attributes, array $guarded_attributes)
	{
		if (!is_null($this->validator)) {
			$attributes = $this->model->newInstance()->forceFill($attributes)->toArray();
			$this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
		}

		$model = $this->model->newInstance($attributes);
		foreach ($guarded_attributes as $key => $value) $model->$key = $value;

		return $model;
	}

	/**
	 * @param Model $model
	 * @return mixed
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 */
	public function saveInstance($model)
	{
		$model->save();
		$this->resetModel();

		event(new RepositoryEntityCreated($this, $model));
		return $this->parserResult($model);
	}

	public function clearCriteria()
	{
		$this->criteria = new Collection();
	}
}