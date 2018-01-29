<?php

namespace App\Models;

use App\Events\OrderFillCreated;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\OrderFill
 *
 * @property int $order_primary_id
 * @property int $order_secondary_id
 * @property float $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereOrderPrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereOrderSecondaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderFill whereQuantity($value)
 */
class OrderFill extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['order_primary_id', 'order_secondary_id', 'quantity'];

	protected $dispatchesEvents = [
		'created' => OrderFillCreated::class,
	];

	public function order_primary()
	{
		return $this->belongsTo(Order::class, 'order_primary_id');
	}
}
