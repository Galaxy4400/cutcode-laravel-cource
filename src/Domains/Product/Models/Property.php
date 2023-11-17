<?php

namespace Domains\Product\Models;

use Domains\Product\Collections\PropertyCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
	];


	public function newCollection(array $models = [])
	{
		return new PropertyCollection($models);
	}
}
