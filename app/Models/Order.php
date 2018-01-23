<?php

namespace App\Models;

use App\Repositories\Criteria\FilledQuantityCriteria;
use App\Repositories\OrderFillRepository;
use App\Repositories\OrderRepository;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\ContainerExceptionInterface;
use Illuminate\Support\Facades\NotFoundExceptionInterface;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;
use Prettus\Repository\Traits\TransformableTrait;
use Psy\Exception\RuntimeException;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $valuta_pair_id
 * @property float $price
 * @property float $fee
 * @property float $quantity
 * @property bool $buy
 * @property int $type
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereValutaPairId($value)
 * @mixin \Eloquent
 * @property-read \App\User $user
 * @property-read \App\Models\ValutaPair $valuta_pair
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderFill[] $order_fills
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders_filled
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders_filling
 * @property mixed pivot
 */
class Order extends BaseModel implements Transformable, Presentable
{
    use TransformableTrait, PresentableTrait;

    const TYPE_LIMIT = 0;
    const TYPE_MARKET = 1;

    const STATUS_OPEN = 0;
    const STATUS_FILLED = 1;
    const STATUS_CANCELLED = 2;

    protected $fillable = ['valuta_pair_id', 'price', 'quantity', 'buy', 'type'];

    protected $filled_quantity = null;

	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function valuta_pair()
    {
        return $this->belongsTo(ValutaPair::class);
    }

    public function order_fills()
    {
        return $this->orders_filling->merge($this->orders_filled);
    }

    /**
     * Get orders that fill this order. All results will be buy orders.
     * @return BelongsToMany
     */
    public function orders_filling()
    {
        return $this->belongsToMany(Order::class, 'order_fills', 'order_secondary_id', 'order_primary_id')->withPivot(['quantity as fill_qty']);
    }

    /**
     * Get orders that are being filled with this one. All results will be sell orders.
     * @return BelongsToMany
     */
    public function orders_filled()
    {
        return $this->belongsToMany(Order::class, 'order_fills', 'order_primary_id', 'order_secondary_id')->withPivot(['quantity as fill_qty']);
    }

	/**
	 * @param bool $invalidate
	 * @return mixed
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function getFilledQuantity($invalidate = false)
	{
		if(isset($this->attributes['filled_qty'])){
			$this->filled_quantity = $this->filled_qty;
			unset($this->attributes['filled_qty']);
		}
		if($this->filled_quantity != null && !$invalidate) return $this->filled_quantity;

		$repo = \App::get(OrderRepository::class);
		$repo->pushCriteria(FilledQuantityCriteria::class);
		$order = $repo->skipPresenter()->find($this->id);
		$this->filled_quantity = $order->filled_qty;
		return $this->filled_quantity;
    }

	public function setFilledQuantity($value)
	{
		$this->filled_quantity = $value;
    }

	/**
	 * Quantity of valuta that is bought
	 * @return float|int
	 */
	public function buyQuantity()
	{
		return !$this->buy ? $this->quantity * $this->price : $this->quantity;
	}

	/**
	 * Quantity of valuta that is bought and filled
	 * @return float|int
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function filledBuyQuantity()
	{
		return !$this->buy ? $this->getFilledQuantity() * $this->price : $this->getFilledQuantity();
	}

	/**
	 * Valuta that is bought
	 * @return Valuta
	 */
	public function buyValuta()
	{
		return !$this->buy ? $this->valuta_pair->valuta_primary : $this->valuta_pair->valuta_secondary;
	}

	/**
	 * Quantity of valuta that is sold
	 * @return float|int
	 */
	public function sellQuantity()
	{
		return $this->buy ? $this->quantity * $this->price : $this->quantity;
    }

	/**
	 * Quantity of valuta that is sold and filled
	 * @return float|int
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function filledSellQuantity()
	{
		return $this->buy ? $this->getFilledQuantity() * $this->price : $this->getFilledQuantity();
	}

	/**
	 * Valuta that is bought
	 * @return Valuta
	 */
	public function sellValuta()
	{
		return $this->buy ? $this->valuta_pair->valuta_primary : $this->valuta_pair->valuta_secondary;
	}
}
