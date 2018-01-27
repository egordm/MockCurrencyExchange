<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
 * @property-read \App\Models\ExternalSymbol $external_symbol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $history
 */
class ValutaPair extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

	public function valuta_primary() {
		return $this->belongsTo(Valuta::class);
	}

	public function valuta_secondary() {
		return $this->belongsTo(Valuta::class);
	}

	public function external_symbol() {
		return $this->hasOne(ExternalSymbol::class);
	}

	public function history() {
		return $this->hasMany(Order::class)->where('status', 1)
			->orderBy('updated_at', 'DESC');
	}
}
