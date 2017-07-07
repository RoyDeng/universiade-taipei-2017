<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use \App\AcForm as AcFormEloquent;
use \App\SignLog as SignLogEloquent;
use \App\Session as SessionEloquent;

class User extends Authenticatable {
    use Notifiable;
	protected $table = 'user';
	public $timestamps = false;

    protected $fillable = [
        'name', 'username', 'password', 'email', 'tel',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

	public function ac_form() {
		return $this -> hasMany(AcFormEloquent::Class);
	}

	public function sign_log() {
		return $this -> hasMany(SignLogEloquent::Class);
	}

	public function session() {
		return $this -> hasOne(SessionEloquent::Class);
	}
}
