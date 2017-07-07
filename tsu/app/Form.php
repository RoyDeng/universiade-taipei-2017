<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\Item as ItemEloquent;
use \App\Location as LocationEloquent;
use \App\User as UserEloquent;
use \App\Eqpt as EqptEloquent;
use \App\ItemDetail as ItemDetailEloquent;

class Form extends Model {
	protected $table = 'form';
	public $timestamps = false;

	protected $fillable = [
		'item_id', 'location_id', 'user_id'
	];

	public function user() {
		return $this -> belongsTo(UserEloquent::Class);
	}

	public function eqpt() {
		return $this -> hasMany(EqptEloquent::Class);
	}

	public function item_detail() {
		return $this -> belongsTo(ItemDetailEloquent::Class);
	}
}
