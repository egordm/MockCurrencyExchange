<?php

namespace App\Repositories;

use App\Models\CandlestickNode;
use App\Models\ValutaPair;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CandlestickNodeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CandlestickNodeRepository extends BaseRepository implements RepositoryInterface
{
	const CANDLESTICK_TICKS = 500;

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
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return CandlestickNode::class;
	}

	/**
	 * Save a large amount of nodes. Pass them as an array of value maps.
	 * @param CandlestickNode[] $nodes
	 * @return bool
	 */
	public function bulkSave($nodes)
	{
		$data = [];
		foreach ($nodes as $node) {
			$data = array_merge($data, [$node->open, $node->high, $node->low, $node->close, $node->volume,
				$node->open_time, $node->close_time, $node->interval, $node->valuta_pair_id]);
		}
		$parameter_holders = implode(',', array_fill(0, count($nodes), '(?,?,?,?,?,?,?,?,?)'));
		return \DB::insert('INSERT IGNORE INTO candlestick_nodes (candlestick_nodes.open, high, low, candlestick_nodes.close, volume, open_time, close_time, candlestick_nodes.interval, valuta_pair_id) VALUES ' . $parameter_holders, $data);
	}

	/**
	 * Get candlestick nodes for specified market, interval and end time
	 * @param ValutaPair $market
	 * @param int $interval in minutes
	 * @param null $start_time
	 * @param null|int $end_time
	 * @return array
	 */
	public function getNodes(ValutaPair $market, $interval, $start_time = null, $end_time = null)
	{
		$full_period = empty($start_time) || empty($end_time);
		if ($end_time == null) $end_time = time() + $interval * 60;
		if ($start_time == null) $start_time = $end_time - ($interval * 60 * (CandlestickNodeRepository::CANDLESTICK_TICKS + 1));

		$res = \DB::table('candlestick_nodes')->whereBetween('close_time', [$start_time, $end_time])
			->where([
				'interval' => $this->getIntervalId($interval),
				'valuta_pair_id' => $market->id
			])->limit(500)->orderBy('close_time', 'ASC')->get()->all();
		return (!$full_period || count($res) >= CandlestickNodeRepository::CANDLESTICK_TICKS) ? $res : [];
	}

	public function getIntervalId($interval)
	{
		return array_search($interval, array_values(CandlestickNodeRepository::INTERVALS));
	}
}