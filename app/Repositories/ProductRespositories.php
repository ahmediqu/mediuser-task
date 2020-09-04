<?php
namespace App\Repositories;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;
class ProductRespositories {

	public function products(){
		return Product::orderBy('id','desc')->paginate(5);
	}
}
