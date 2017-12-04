<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\OrderFill
 *
 * @property int $order_primary_id
 * @property int $order_secondary_id
 * @property float $percentage
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereOrderPrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereOrderSecondaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderFill extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
