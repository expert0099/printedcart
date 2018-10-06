<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserUpload extends Model
{
    protected $table = 'user_uploads';
	
	/* public function Album(){
		return $this->belongsTo('App\Album', 'album_id', 'id');
	}  */
}
