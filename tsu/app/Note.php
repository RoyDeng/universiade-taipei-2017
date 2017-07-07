<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\ItemDetail as ItemDetailEloquent;

class Note extends Model {
	protected $table = 'note';
	public $timestamps = false;

	protected $fillable = [
		'item_detail_id', 'remark'
	];

	public function item_detail() {
		return $this -> belongsTo(ItemDetailEloquent::Class);
	}
}
