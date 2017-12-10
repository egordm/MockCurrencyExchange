<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class ValutaMarketCriteria
 * @package namespace App\Repositories\Criteria;
 */
class ValutaMarketCriteria implements CriteriaInterface
{
	/**
	 * @var array
	 */
	protected $valutae;

	/**
	 * ValutaMarketCriteria constructor.
	 * @param string $market
	 */
	public function __construct($market)
	{
		$this->valutae =  explode('_', strtoupper($market));
		if(count($this->valutae) != 2) throw new NotFoundResourceException();
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
        return $model->leftJoin('valuta as vftr', function ($join) {
	        $join->where(function ($query) {
		        $query->whereColumn('valuta_pairs.valuta_primary_id', 'vftr.id');
		        $query->orWhere(function ($query) {
			        $query->whereColumn('valuta_pairs.valuta_secondary_id', 'vftr.id');
		        });
	        })->where(function ($query) {
		        $query->where('vftr.symbol', $this->valutae[0]);
		        $query->orWhere('vftr.symbol', $this->valutae[1]);
	        });
        })->addSelect('valuta_pairs.*')->groupBy('valuta_pairs.id')->havingRaw('COUNT(vftr.id) = 2');
    }
}
