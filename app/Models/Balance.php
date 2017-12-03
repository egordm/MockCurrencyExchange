<?php

namespace App\Models;

use App\Repositories\Presenters\BalancePresenter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\PresenterInterface;
use Prettus\Repository\Traits\PresentableTrait;

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
class Balance extends Model implements Presentable
{
	use PresentableTrait;

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function valuta() {
	    return $this->belongsTo(Valuta::class);
    }
}
