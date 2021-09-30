<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::query()
                    ->with('productVariant', 'productPrice')
                    ->get()
                    ->toArray();

        $variants = Variant::all();

        // $user = User::select("users.*","items.id as itemId","jobs.id as jobId")
        //         ->join("items","items.user_id","=","users.id")
        //         ->join("jobs",function($join){
        //             $join->on("jobs.user_id","=","users.id")
        //                 ->on("jobs.item_id","=","items.id");
        //         })
        //         ->get();
        
        $product_variants = DB::table('product_variants')
                    ->join('product_variant_prices', function($join){
                        $join->on('product_variant_prices.product_variant_one', '=', 'product_variants.id');
                    })
                    ->get();
        // dd($products);
        return view('products.index')->with(compact('products', 'variants', 'product_variants'));
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
        Product::create([
            'title' => $request->title,
            'sku' => $request->sku,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Product added successfully');
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
       $product = DB::table('products')->where('id',$product->id)->first();
    //    return response()->json($product);
        return view('products.edit')->with(compact('product'));
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
        $product->update([
            'title' => $request->title,
            'sku' => $request->sku,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::where('id', $product->id)->delete();
        return back()->with('success', 'Product has been deleted');
    }
}
