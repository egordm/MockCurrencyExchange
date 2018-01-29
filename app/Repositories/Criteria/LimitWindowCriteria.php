<?php

namespace App\Repositories\Criteria;

use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LimitWindowCriteriaCriteria
 * @package namespace App\Repositories\Criteria;
 */
class LimitWindowCriteria implements CriteriaInterface
{
	private $table = '';
	private $limit = 60;
	private $start_time = null;
	private $end_time = null;

	/**
	 * LimitWindowCriteria constructor.
	 * @param string $table
	 * @param int $limit
	 * @param null $start_time
	 * @param null $end_time
	 */
	public function __construct(string $table, int $limit, $start_time=null, $end_time=null)
	{
		$this->table = $table;
		$this->limit = $limit;

		$this->start_time = is_numeric($start_time) ? Carbon::createFromTimestamp($start_time) : $start_time;
		$this->end_time = is_numeric($end_time) ? Carbon::createFromTimestamp($end_time) : $end_time;
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
        return $model->when(!empty($this->start_time), function ($query) use ($model) {
	        return $query->where($this->table.'.updated_at', '>=', $this->start_time);
        })->when(!empty($this->end_time), function ($query) use ($model) {
	        return $query->where($this->table.'.updated_at', '<=', $this->end_time);
        })->limit($this->limit);
    }
}
