<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Balance
 *
 * @property int $id
 * @property int $user_id
 * @property int $valuta_id
 * @property float $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balance whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balance whereValutaId($value)
 * @mixin \Eloquent
 * @property-read \App\User $user
 * @property-read \App\Models\Valuta $valuta
 */
	class Balance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ValutaPair
 *
 * @property int $id
 * @property int $valuta_primary_id
 * @property int $valuta_secondary_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ValutaPair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ValutaPair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ValutaPair whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ValutaPair whereValutaPrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ValutaPair whereValutaSecondaryId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Valuta $valuta_primary
 * @property-read \App\Models\Valuta $valuta_secondary
 */
	class ValutaPair extends \Eloquent {}
}

namespace App\Models{
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
	class OrderFill extends \Eloquent {}
}

namespace App\Models{
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
	class Order extends \Eloquent {}
}

namespace App\Models{
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
	class Valuta extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property int $role
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Balance[] $balances
 */
	class User extends \Eloquent {}
}

