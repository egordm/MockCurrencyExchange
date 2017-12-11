<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\CandlestickNode
 *
 * @property float $open
 * @property float $high
 * @property float $low
 * @property float $close
 * @property float $volume
 * @property int $open_time
 * @property int $close_time
 * @property int $interval
 * @property int $valuta_pair_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereCloseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereOpenTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereValutaPairId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CandlestickNode whereVolume($value)
 * @mixin \Eloquent
 */
class CandlestickNode extends Model implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

	public $timestamps = false;

}
