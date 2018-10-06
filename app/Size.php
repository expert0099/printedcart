<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';
	
	public function Currency(){
		return $this->hasOne('App\Currency', 'currency', 'id');
	}
	
	public function SizeGroup(){
		return $this->hasOne('App\SizeGroup', 'id', 'sizegroup');
	}

}
