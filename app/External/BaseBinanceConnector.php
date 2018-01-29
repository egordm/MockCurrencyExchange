<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 28-1-2018
 * Time: 18:15
 */

namespace App\External;


use App\Repositories\CandlestickNodeRepository;

class BaseBinanceConnector
{
	/**
	 * @var \Binance\API
	 */
	protected $api;

	protected $base = "https://api.binance.com/api/";
	protected $wapi = "https://api.binance.com/wapi/";
	protected $api_key;
	protected $api_secret;
	protected $info = [];

	/**
	 * BaseBinanceConnector constructor.
	 */
	public function __construct()
	{
		$this->api = new \Binance\API(env('BINANCE_API_KEY'), env('BINANCE_SECRET_KEY'));
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 * @throws \Exception
	 */
	public function __call($name, $arguments)
	{
		if (method_exists($this->api, $name)) return call_user_func_array([$this->api, $name], $arguments);
		throw new \Exception('Method ' . $name . ' not exists');
	}

	public function requestCandlesticks($symbol, $interval = '15m', $start_time = null, $end_time = null)
	{
		$params = ["symbol" => $symbol, "interval" => $interval];
		$interval_time = CandlestickNodeRepository::INTERVALS[$interval];

		// TODO: remove magic number (3)
		if (!empty($start_time)) $params['startTime'] = ($start_time - ($interval_time * 60 * 4)) * 1000;
		if (!empty($end_time)) $params['endTime'] = $end_time * 1000;
		$response = $this->request("v1/klines", $params);
		if (empty($response)) return [];
		$ticks = $this->chartData($symbol, $interval, $response);
		return $ticks;
	}

	protected function request($url, $params = [], $method = "GET")
	{
		$opt = [
			"http" => [
				"method" => $method,
				"header" => "User-Agent: Mozilla/4.0 (compatible; PHP Binance API)\r\n"
			]
		];
		$context = stream_context_create($opt);
		$query = http_build_query($params, '', '&');
		return json_decode(file_get_contents($this->base . $url . '?' . $query, false, $context), true);
	}

	protected function chartData($symbol, $interval, $ticks)
	{
		if (!isset($this->info[$symbol])) $this->info[$symbol] = [];
		if (!isset($this->info[$symbol][$interval])) $this->info[$symbol][$interval] = [];
		$output = [];
		foreach ($ticks as $tick) {
			list($openTime, $open, $high, $low, $close, $assetVolume, $closeTime, $baseVolume, $trades, $assetBuyVolume, $takerBuyVolume, $ignored) = $tick;
			$output[] = [
				"open" => $open,
				"high" => $high,
				"low" => $low,
				"close" => $close,
				"volume" => $baseVolume,
				"openTime" => $openTime,
				"closeTime" => $closeTime
			];
		}
		$this->info[$symbol][$interval]['firstOpen'] = $openTime;
		return $output;
	}
}