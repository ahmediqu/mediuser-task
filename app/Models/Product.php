<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;
class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description'
    ];

    protected $guarded = ['id'];

    public function variant(){
    	return $this->hasMany(ProductVariant::class,'product_id');
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


}
