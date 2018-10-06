<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Covercategory extends Model
{
    protected $table = 'covercategories';
	
	public function Coversubcategory(){
		return $this->hasOne('App\Coversubcategory', 'cover_category_id', 'id');
	}
}
