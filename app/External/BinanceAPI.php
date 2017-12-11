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

class BinanceAPI
{
	/**
	 * @var \Binance\API
	 */
	protected $api;

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
		$this->api = new \Binance\API(env('BINANCE_API_KEY'), env('BINANCE_SECRET_KEY'));
		$this->candleRepo = $candleRepo;
	}


	/**
	 * @param ValutaPair $market
	 * @param string $interval
	 * @return array
	 * @throws \Exception
	 */
	public function candlesticks(ValutaPair $market, $interval = '15m')
	{
		if (!isset(CandlestickNodeRepository::INTERVALS[$interval])) throw new \Exception('Invalid interval');
		$interval_time = CandlestickNodeRepository::INTERVALS[$interval];
		$nodes = $this->candleRepo->getNodes($market, $interval_time);

		if(empty($nodes)) {
			$interval_id = $this->candleRepo->getIntervalId($interval_time);
			$ticks = $this->api->candlesticks($market->external_symbol->symbol, $interval);
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

		return $nodes;
	}
}