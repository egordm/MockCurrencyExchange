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

	protected $base = "https://api.binance.com/api/", $wapi = "https://api.binance.com/wapi/", $api_key, $api_secret;
	protected $info = [];

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
		} catch (\Exception $e) {}

		return $nodes;
	}

	public function requestCandlesticks($symbol, $interval = '15m', $start_time = null, $end_time = null)
	{
		$params = ["symbol" => $symbol, "interval" => $interval];
		$interval_time = CandlestickNodeRepository::INTERVALS[$interval];

		// TODO: remove magic number (3)
		if(!empty($start_time)) $params['startTime'] = ($start_time - ($interval_time * 60 * 4)) * 1000;
		if(!empty($end_time)) $params['endTime'] = $end_time * 1000;
		$response = $this->request("v1/klines", $params);
		if(empty($response)) return [];
		$ticks = $this->chartData($symbol, $interval, $response);
		return $ticks;
	}

	private function request($url, $params = [], $method = "GET") {
		$opt = [
			"http" => [
				"method" => $method,
				"header" => "User-Agent: Mozilla/4.0 (compatible; PHP Binance API)\r\n"
			]
		];
		$context = stream_context_create($opt);
		$query = http_build_query($params, '', '&');
		return json_decode(file_get_contents($this->base.$url.'?'.$query, false, $context), true);
	}

	private function chartData($symbol, $interval, $ticks) {
		if ( !isset($this->info[$symbol]) ) $this->info[$symbol] = [];
		if ( !isset($this->info[$symbol][$interval]) ) $this->info[$symbol][$interval] = [];
		$output = [];
		foreach ( $ticks as $tick ) {
			list($openTime, $open, $high, $low, $close, $assetVolume, $closeTime, $baseVolume, $trades, $assetBuyVolume, $takerBuyVolume, $ignored) = $tick;
			$output[] = [
				"open" => $open,
				"high" => $high,
				"low" => $low,
				"close" => $close,
				"volume" => $baseVolume,
				"openTime" =>$openTime,
				"closeTime" =>$closeTime
			];
		}
		$this->info[$symbol][$interval]['firstOpen'] = $openTime;
		return $output;
	}
}