<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderByNewestCriteria
 * @package namespace App\Repositories\Criteria;
 */
class OrderByNewestCriteria implements CriteriaInterface
{
	private $table = '';
	private $field = '';

	/**
	 * OrderByNewestCriteria constructor.
	 * @param string $table
	 * @param string $field
	 */
	public function __construct(string $table, string $field = 'updated_at')
	{
		$this->table = $table;
		$this->field = $field;
	}


	/**
	 * Apply criteria in query repository
	 *
	 * @param                     $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		return $model->orderBy($this->table . '.' . $this->field, 'DESC');
	}
}
