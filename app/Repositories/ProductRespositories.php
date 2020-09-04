<?php
namespace App\Repositories;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;
class ProductRespositories {

	public function products(){
		return Product::orderBy('id','desc')->get()->map(function($product) {
			return [
				'id' => $product->id,
				'title' => $product->title,
				'description' => $product->description,
				'created_at' => $product->created_at->diffForHumans()
			];
		});
	}
}
