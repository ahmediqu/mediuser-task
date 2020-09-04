<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Repositories\ProductRespositories;
use Carbon\Carbon;
use DB;
class ProductController extends Controller
{
    private $productRespositories;

    public function __construct(ProductRespositories $productRespositories){
        $this->productRespositories = $productRespositories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $data = [];
        $data['products'] = $this->productRespositories->products();
        $data['varinat'] = ProductVariant::groupBy('variant')->get();
        return view('products.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // dd($request->image);
        // exit();
        $product_name = $request->product_name;
        $product_sku = $request->product_sku;
        $description = $request->description;
        $validatedData = $request->validate([
            'product_name' => ['required'],
            'product_sku' => ['required'],
            'description' => ['required'],
        ]);

        if ($product_name) {
            $savedata = new Product();
            $savedata->title = $product_name;
            $savedata->sku = $product_sku;
            $savedata->description = $description;
            $savedata->save();
        }
    
     
            
           $data=array();
           $data['product_id'] = $savedata->id;





            $produt_image = new ProductImage;
            if($files=$request->file('image')){
                foreach($files as $file){


                    $image_name = time().'.'.$file->getClientOriginalExtension();


                    $image_full_name = $image_name;
                    $destination_path = 'uploads/products/';
                    $image_url = $destination_path . $image_full_name;
                    $success = $file->move($destination_path, $image_full_name);
                    if ($success) {
                        
                       $data['file_path']=$success;
                    }
                    $produt_image->create($data);
                }

        }
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function filter(Request $request){
        $title = $request->title;
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $date = Carbon::parse($request->date);

        $data = [];
        $data['products'] = DB::table('products')
                    ->orWhere('title', $title)
                    ->orWhere('created_at', '>=', $date)
                    ->get();
        return view('products.filter',$data);
    }
}
