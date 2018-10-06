<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{
    protected $table = 'shippingprices';
	
	public function ShippingCategory(){
		return $this->hasOne('App\ShippingCategory', 'id', 'shipping_category_id');
	}
}
