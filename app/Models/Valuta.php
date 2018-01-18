<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * App\Models\Valuta
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $symbol
 * @property string $name
 * @property int $decimal_places
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Valuta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Valuta whereDecimalPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Valuta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Valuta whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Valuta whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Valuta whereUpdatedAt($value)
 */
class Valuta extends BaseModel implements Presentable
{
	use PresentableTrait;

	public function getTable()
	{
		return 'valuta';
	}
}
