<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\CheckLog as CheckLogEloquent;
use \App\Item as ItemEloquent;
use \App\Location as LocationEloquent;
use \App\Note as NoteEloquent;
use \App\Form as FormEloquent;

class ItemDetail extends Model {
	protected $table = 'item_detail';
	public $timestamps = false;

	protected $fillable = [
		'abbr', 'item_id', 'location_id'
	];

	public function check_log() {
		return $this -> hasMany(CheckLogEloquent::Class);
	}

	public function item() {
		return $this -> belongsTo(ItemEloquent::Class);
	}

	public function location() {
		return $this -> belongsTo(LocationEloquent::Class);
	}

	public function note() {
		return $this -> hasMany(NoteEloquent::Class);
	}
	
	public function form() {
		return $this -> hasMany(FormEloquent::Class);
	}
}
