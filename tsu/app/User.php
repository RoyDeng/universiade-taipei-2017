<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use \App\Form as FormEloquent;

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
		return $this -> hasMany(FormEloquent::Class);
	}
}
