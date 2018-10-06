<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCategory extends Model
{
    protected $table = 'calendarcategories';
	
	public function CalendarDefaultSize(){
		return $this->hasOne('App\CalendarDefaultSize', 'calendar_category_id', 'id');
	}
	/* public function CalendarStyle(){
		return $this->hasMany('App\CalendarStyle', 'calendar_category_id', 'id');
	} */
}
