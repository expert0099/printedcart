<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeGroup extends Model
{
    protected $table = 'sizegroups';
	
	public function Size(){
		return $this->hasMany('App\Size', 'sizegroup', 'id');
	}
	
}
