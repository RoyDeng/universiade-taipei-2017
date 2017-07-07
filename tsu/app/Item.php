<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\ItemDetail as ItemDetailEloquent;
use \App\Eqpt as EqptEloquent;

class Item extends Model {
	protected $table = 'item';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function item_detail() {
		return $this -> hasMany(ItemDetailEloquent::Class);
	}

	public function eqpt() {
		return $this -> hasMany(EqptEloquent::Class);
	}
}