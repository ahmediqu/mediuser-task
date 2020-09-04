<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class ProductVariant extends Model
{
	public function variant(){
    	    return $this->belongsToMany(Product::class);

    }
}
