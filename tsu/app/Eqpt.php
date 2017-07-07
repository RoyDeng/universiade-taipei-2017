<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\Item as ItemEloquent;
use \App\Location as LocationEloquent;
use \App\Form as FormDetailEloquent;
use \App\Abnormal as AbnormalEloquent;

class Eqpt extends Model {
	protected $table = 'eqpt';
	public $timestamps = false;

	protected $fillable = [
		'item_id', 'location_id', 'name', 'quantity', 'unit', 'check_quantity'
	];

	public function item() {
		return $this -> belongsTo(ItemEloquent::Class);
	}

	public function location() {
		return $this -> belongsTo(LocationEloquent::Class);
	}

	public function form() {
		return $this -> belongsTo(FormDetailEloquent::Class);
	}

	public function abnormal() {
		return $this -> hasMany(AbnormalEloquent::Class);
	}
}
