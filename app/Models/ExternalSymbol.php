<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExternalSymbol
 *
 * @property int $valuta_pair_id
 * @property string $symbol
 * @property int $type
 * @property-read \App\Models\ValutaPair $valuta_pair
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExternalSymbol whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExternalSymbol whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExternalSymbol whereValutaPairId($value)
 * @mixin \Eloquent
 */
class ExternalSymbol extends BaseModel
{
	public function valuta_pair() {
		return $this->belongsTo(ValutaPair::class);
	}
}
