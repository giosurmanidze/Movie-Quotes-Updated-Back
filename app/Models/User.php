<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
	use HasApiTokens;

	use HasFactory;

	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = ['id'];

	public $remember_token = false;

	public function movies()
	{
		return $this->hasMany(Movie::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	public function sendEmailVerificationNotification()
	{
		$this->notify(new VerifyEmail());
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
	}

	public function notifications(): HasMany
	{
		return $this->hasMany(Notification::class);
	}

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'password'          => 'hashed',
	];
}
