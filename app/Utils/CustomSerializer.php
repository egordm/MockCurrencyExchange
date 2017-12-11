<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 01:00
 */

namespace App\Utils;


use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractalistic\ArraySerializer;

class CustomSerializer extends ArraySerializer
{
	public function collection($resourceKey, array $data)
	{
		if ($resourceKey) {
			return [$resourceKey => $data];
		}
		return $data;
	}

	public function item($resourceKey, array $data)
	{
		if ($resourceKey) {
			return [$resourceKey => $data];
		}
		return $data;
	}
}