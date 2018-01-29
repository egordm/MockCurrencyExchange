<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 20:45
 */

namespace App\External;


use App\Models\CandlestickNode;
use App\Models\ValutaPair;
use App\Repositories\CandlestickNodeRepository;

class BinanceAPI extends BaseBinanceConnector
{
	/**
	 * @var CandlestickNodeRepository
	 */
	protected $candleRepo;

	/**
	 * BinanceAPI constructor.
	 * @param CandlestickNodeRepository $candleRepo
	 */
	public function __construct(CandlestickNodeRepository $candleRepo)
	{
		parent::__construct();
		$this->candleRepo = $candleRepo;
	}


	/**
	 * @param ValutaPair $market
	 * @param string $interval
	 * @param null|int $start_time
	 * @param null|int $end_time
	 * @return array
	 * @throws \Exception
	 */
	public function candlesticks(ValutaPair $market, $interval = '15m', $start_time = null, $end_time = null)
	{
		if (!isset(CandlestickNodeRepository::INTERVALS[$interval])) throw new \Exception('Invalid interval');
		$interval_time = CandlestickNodeRepository::INTERVALS[$interval];
		$nodes = $this->candleRepo->getNodes($market, $interval_time, $start_time, $end_time);

		try {
			if (empty($nodes) || count($nodes) == 1) {
				$nodes = [];
				$interval_id = $this->candleRepo->getIntervalId($interval_time);
				$ticks = $this->requestCandlesticks($market->external_symbol->symbol, $interval, $start_time, $end_time);
				if (!empty($ticks)) {
					foreach ($ticks as $tick) {
						$nodes[] = new CandlestickNode([
							'open' => $tick['open'],
							'high' => $tick['high'],
							'low' => $tick['low'],
							'close' => $tick['close'],
							'volume' => $tick['volume'],
							'open_time' => $tick['openTime'] / 1000,
							'close_time' => $tick['closeTime'] / 1000,
							'interval' => $interval_id,
							'valuta_pair_id' => $market->id
						]);
					}
					$this->candleRepo->bulkSave($nodes);
				}
			}
		} catch (\Exception $e) {
		}

		return $nodes;
	}
}