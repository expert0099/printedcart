<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
	
	public function UserUpload(){
		return $this->hasMany('App\UserUpload', 'album_id', 'id')->where('deleted_at','=','0000-00-00 00:00:00');
	}
}
