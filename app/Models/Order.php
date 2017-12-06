<?php

namespace App\Models;

use App\Repositories\OrderFillRepository;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\ContainerExceptionInterface;
use Illuminate\Support\Facades\NotFoundExceptionInterface;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;
use Prettus\Repository\Traits\TransformableTrait;

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
 * @property bool $settled
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereSettled($value)
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
class Order extends Model implements Transformable, Presentable
{
    use TransformableTrait, PresentableTrait;

    const TYPE_LIMIT = 0;
    const TYPE_MARKET = 1;

    const STATUS_OPEN = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DONE = 2;
    const STATUS_CANCELLED = 3;

    protected $fillable = [];

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
        return $this->belongsToMany(Order::class, 'order_fills', 'order_secondary_id', 'order_primary_id')->withPivot(['percentage']);
    }

    /**
     * Get orders that are being filled with this one. All results will be sell orders.
     * @return BelongsToMany
     */
    public function orders_filled()
    {
        return $this->belongsToMany(Order::class, 'order_fills', 'order_primary_id', 'order_secondary_id')->withPivot(['percentage']);
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     *
     * Get a percentage that is filled by the order
     * @param Order $order
     * @return float
     */
    public function fill_percentage(Order $order)
    {
        if (isset($order->pivot)) $percentage = $order->pivot->percentage;
        else {
            /** @noinspection PhpUnhandledExceptionInspection */
            $fill = \App::get(OrderFillRepository::class)->skipPresenter()
                ->findById($this->buy ? $this->id : $order->id, $this->buy ? $order->id : $this->id)->first();
            if (!$fill) return 0;
            $percentage = $fill->percentage;
        }

        return ($order->buy) ? $percentage : ($order->quantity * $percentage) / $this->quantity;
    }

    /**
     * Get a percentage of the order that is filled
     */
    public function filled_percentage()
    {
        $fills = $this->buy ? $this->orders_filled : $this->orders_filling;
        $ret = 0;
        foreach ($fills as $fill) $ret += $this->fill_percentage($fill);
        return $ret;
    }

    public function balance()
    {
        $pair = $this->valuta_pair;
        $fp = $this->filled_percentage();
        return [
            $pair->valuta_primary_id => ($this->buy ? -1 : 1) * ($this->quantity * $fp) * $this->price,
            $pair->valuta_secondary_id => ($this->buy ? 1 : -1) * $this->quantity * (1 - $fp),

        ];
	}
}
