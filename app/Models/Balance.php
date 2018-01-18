<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
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
class Balance extends BaseModel implements Presentable
{
	use PresentableTrait;

	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function valuta()
	{
		return $this->belongsTo(Valuta::class);
	}

	public function mutate($mutation)
	{
		$query = 'INSERT INTO balances (user_id, valuta_id, quantity, created_at, updated_at) ' .
			'VALUES (?,?,?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)' .
			' ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity), updated_at = CURRENT_TIMESTAMP()';
		\DB::insert($query, [$this->user_id, $this->valuta_id, $mutation]);
		$this->quantity += $mutation;
	}
}
