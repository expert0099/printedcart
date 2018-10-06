<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarStyle extends Model
{
    protected $table = 'calendarstyles';
	
	public function CalendarCategory(){
		return $this->hasOne('App\CalendarCategory', 'id', 'calendar_category_id');
	}
}
