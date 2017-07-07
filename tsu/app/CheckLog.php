<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\User as UserEloquent;
use \App\ItemDetail as ItemDetailEloquent;

class CheckLog extends Model {
	protected $table = 'check_log';
	public $timestamps = false;

	protected $fillable = [
		'check_in_time', 'check_out_time',
	];

	public function user() {
		return $this -> belongsTo(UserEloquent::Class);
	}

	public function item_detail() {
		return $this -> belongsTo(ItemDetailEloquent::Class);
	}
}
