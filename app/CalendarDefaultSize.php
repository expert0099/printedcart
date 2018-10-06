<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarDefaultSize extends Model
{
    protected $table = 'calendardefaultsizes';
	
	public function Size(){
		return $this->hasOne('App\Size', 'id', 'size_id');
	}
	
	public function CalendarCategory(){
		return $this->hasOne('App\CalendarCategory', 'id', 'calendar_category_id');
	}
	
}
