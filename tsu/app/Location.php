<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\Eqpt as EqptEloquent;
use \App\ItemDetail as ItemDetailEloquent;
use \App\Notification as NotificationEloquent;

class Location extends Model {
	protected $table = 'location';
	public $timestamps = false;

	protected $fillable = [
		'name', 'address', 'latitude', 'longitude'
	];

	public function eqpt() {
		return $this -> hasMany(EqptEloquent::Class);
	}

	public function item_detail() {
		return $this -> hasOne(ItemDetailEloquent::Class);
	}
}
