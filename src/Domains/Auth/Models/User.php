<?php

namespace Domains\Auth\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Models\HasThumbnail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @method static Builder|User query()
 */
class User extends Authenticatable
{
	use HasApiTokens;
	use HasFactory;
	use Notifiable;
	use HasThumbnail;


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'github_id',
	];

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
		'password' => 'hashed',
	];


	protected function avatar(): Attribute
	{
		return Attribute::make(
			get: fn () => "https://ui-avatars.com/api/?name=" . $this->name . "&background=random",
		);
	}


	protected function thumbnailDir(): string
	{
		return 'products';
	}
}
