<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photobook extends Model
{
    protected $table = 'photobooks';
	
	/* public function Photobookbackground(){
		return $this->hasOne('App\Photobookbackground', 'id', 'photo_book_id');
	}
	
	public function Photobookembellishment(){
		return $this->hasOne('App\Photobookembellishment', 'id', 'photo_book_id');
	}
	
	public function Photobookideapage(){
		return $this->hasOne('App\Photobookideapage', 'id', 'photo_book_id');
	} */
}
