<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
	
	/* public function Cart(){
		return $this->hasOne('App\Cart', 'project_id', 'id')->where('status',0);
	} */
	public function Size(){
		return $this->belongsTo('App\Size', 'size_id', 'id');
	} 
	public function Photobook(){
		return $this->belongsTo('App\Photobook', 'photobook_id', 'id');
	} 
	public function User(){
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
	public function SavedUserProject(){
		return $this->hasMany('App\SavedUserProject', 'project_id', 'id');
	}
	public function Order(){
		return $this->belongsTo('App\Order', 'id', 'project_id');
	}
}
