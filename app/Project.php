<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
	
	public function Cart(){
		return $this->hasOne('App\Cart', 'project_id', 'id')->where('status',0);
	}
	public function Size(){
		return $this->belongsTo('App\Size', 'size_id', 'id');
	} 
	public function Photobook(){
		return $this->belongsTo('App\Photobook', 'photobook_id', 'id');
	} 
	public function CalendarStyle(){
		return $this->belongsTo('App\CalendarStyle', 'calendar_style_id', 'id');
	} 
	public function Order(){
		return $this->hasOne('App\Order', 'project_id', 'id');
	}
}
