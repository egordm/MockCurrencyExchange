<?php

namespace App;

use App\Models\Balance;
use App\Models\Order;
use App\Models\Valuta;
use App\Repositories\BalanceRepository;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $open_orders
 */
class User extends Authenticatable
{
	use HasApiTokens, Notifiable;

	const ROLE_PLEB = 0;
	const ROLE_BOT = 13;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = bcrypt($password);
	}

	public function balances()
	{
		return $this->hasMany(Balance::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function open_orders()
	{
		return $this->hasMany(Order::class)->where('orders.status', '=', Order::STATUS_OPEN);
	}

	public function getBalance(Valuta $valuta)
	{
		if ($this->isBot()) return PHP_FLOAT_MAX;

		/** @noinspection PhpUnhandledExceptionInspection */
		$balance = \App::get(BalanceRepository::class)->skipPresenter()->getBalance($this, $valuta)->first();
		return (!$balance) ? 0 : $balance->quantity;
	}

	public function getHaltedBalance(Valuta $valuta)
	{
		if ($this->isBot()) return 0;
		/** @noinspection PhpUnhandledExceptionInspection */
		return \App::get(BalanceRepository::class)->getHaltedBalance($this, $valuta);
	}

	public function isBot()
	{
		return $this->role == self::ROLE_BOT;
	}

	public static function bots($with = null)
	{
		$ret = User::where('role', '=', User::ROLE_BOT);
		if(!empty($with)) $ret = $ret->with($with);
		return $ret->get();
	}
}
