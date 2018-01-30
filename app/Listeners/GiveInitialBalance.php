<?php

namespace App\Listeners;

use App\Repositories\BalanceRepository;
use App\Repositories\ValutaPairRepository;
use App\Repositories\ValutaRepository;
use Illuminate\Auth\Events\Registered;
use Prettus\Validator\Exceptions\ValidatorException;

class GiveInitialBalance
{
	const DEFAULT_INITIAL_BALANCE = 5000;

	/**
	 * @var ValutaRepository
	 */
	private $valutaRepository;
	/**
	 * @var BalanceRepository
	 */
	private $balanceRepository;

	/**
	 * GiveInitialBalance constructor.
	 * @param ValutaRepository $valutaRepository
	 * @param ValutaPairRepository $valutaPairRepository
	 * @param BalanceRepository $balanceRepository
	 */
	public function __construct(ValutaRepository $valutaRepository, BalanceRepository $balanceRepository)
	{
		$this->valutaRepository = $valutaRepository;
		$this->balanceRepository = $balanceRepository;
	}

	/**
	 * Handle the event.
	 * @param  Registered $event
	 * @return void
	 */
	public function handle(Registered $event)
	{
		$fiat = $this->valutaRepository->skipPresenter()->findWhere(['symbol' => 'USD'], ['symbol', 'id'])->first();
		if(!$fiat) return;

		try {
			$this->balanceRepository->create([
				'user_id' => $event->user->id,
				'valuta_id' => $fiat->id,
				'quantity' => GiveInitialBalance::DEFAULT_INITIAL_BALANCE
			]);
		} catch (ValidatorException $e) {
		}
	}
}
