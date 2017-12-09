<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 3-12-2017
 * Time: 22:03
 */

namespace API\Controllers;


use App\Repositories\Presenters\ValutaPresenter;
use App\Repositories\ValutaPairRepository;
use Infrastructure\Controllers\APIController;
use Prettus\Repository\Contracts\PresenterInterface;

class MarketController extends APIController
{
	/**
	 * @var ValutaPairRepository
	 */
	private $valutaPairRepository;

	/**
	 * MarketController constructor.
	 * @param ValutaPairRepository $valutaPairRepository
	 */
	public function __construct(ValutaPairRepository $valutaPairRepository)
	{
		$this->valutaPairRepository = $valutaPairRepository;
	}


	public function index() {
		return $this->valutaPairRepository->all_display();
	}

	/**
	 * @return PresenterInterface
	 */
	public function presenter()
	{
		return new ValutaPresenter();
	}
}