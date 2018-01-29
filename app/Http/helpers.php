<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 28-1-2018
 * Time: 20:51
 */

/**
 * Cut a pie randomly and everyone "something"
 * @param $n_agents
 * @param int $zero_probability
 * @return array
 */
function random_distribution($n_agents, $zero_probability = 0.2)
{
	$slices = [];
	for ($i = 0; $i < $n_agents; $i++) $slices[] = rand(0, 100) < $zero_probability * 100 ? 0 : rand(0, 100);
	// Yes i know probability is not 100% correct. But its eazy to read
	$pie = array_sum($slices);
	if($pie == 0) {
		$pie = 1;
		$slices[0] = 1;
	}
	return array_map(function ($value) use ($pie) {
		return $value / $pie;
	}, $slices);
}

function weighted_average_max($values, $weight = 0.5) {
	$max_bid = max($values);
	$avg_bid = array_sum($values) / count($values);
	return $max_bid * $weight + $avg_bid * (1 - $weight);
}