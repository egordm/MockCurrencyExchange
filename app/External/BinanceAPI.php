<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 20:45
 */

namespace App\External;


class BinanceAPI
{
	const INTERVALS = [
		'1m' => 1,
		'3m' => 3,
		'5m' => 5,
		'15m' => 15,
		'30m' => 30,
		'1h' => 60,
		'2h' => 120,
		'4h' => 240,
		'6h' => 360,
		'8h' => 480,
		'12h' => 720,
		'1d' => 1440,
		'3d' => 4320,
		'1w' => 10080,
		'1M' => 43830
	];

	/**
	 * @var \Binance\API
	 */
	protected $api;

	/**
	 * BinanceAPI constructor.
	 */
	public function __construct()
	{
		$this->api = new \Binance\API(env('BINANCE_API_KEY'), env('BINANCE_SECRET_KEY'));
	}


	/**
	 * @param $symbol
	 * @param string $interval
	 * @return array
	 * @throws \Exception
	 */
	public function candlesticks($symbol, $interval = '15m')
	{
		if(!isset(BinanceAPI::INTERVALS[$interval])) throw new \Exception('Invalid interval');
		return $this->api->candlesticks($symbol, $interval);
	}


}