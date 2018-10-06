<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $table = 'promocodes';
	
	public function Coupon(){
		return $this->hasOne('App\Coupon', 'promocode_id', 'id');
	}
}
