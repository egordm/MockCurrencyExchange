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

	/**
	 * OrderByNewestCriteria constructor.
	 * @param string $table
	 */
	public function __construct(string $table)
	{
		$this->table = $table;
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
        return $model->orderBy($this->table.'.updated_at', 'DESC');
    }
}
