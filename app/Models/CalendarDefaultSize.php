<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarDefaultSize extends Model
{
    use SoftDeletes;
	
	protected $table = 'calendardefaultsizes';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
	
	public function CalendarCategory(){
        return $this->belongsTo('App\models\CalendarCategory');
    }
}
