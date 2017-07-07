<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\Eqpt as EqptEloquent;

class Abnormal extends Model {
	protected $table = 'abnormal';
	public $timestamps = false;

	protected $fillable = [
        'eqpt_id', 'quantity', 'remark', 'pic', 'signature'
    ];

	public function eqpt() {
		return $this -> belongsTo(EqptEloquent::Class);
	}
}
