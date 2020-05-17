<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return Product::all();
//        return response(Product::all());
        return response()->json(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description
        ];
        $product = Product::create($data);
        if ($product){
            return response()->json([
                'data' => $product,
                'status' => 'success',
                'statusCode' => '200',
                'message' => 'Product Created.'
            ], 201);
        }
        return response()->json([
            'data' => null,
            'status' => 'error',
            'statusCode' => '404',
            'message' => 'Product Not Created.'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'data' => $product,
                'status' => 'success',
                'statusCode' => '200',
                'message' => 'Product Found.'
            ], 200);
        }
        return response()->json([
            'data' => null,
            'status' => 'error',
            'statusCode' => '404',
            'message' => 'Product Not Found.'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description
        ];
        if ($product->update($data)){
            return response()->json([
                'data' => $product,
                'status' => 'success',
                'statusCode' => '200',
                'message' => 'Product Updated.'
            ], 200);
        }
        return response()->json([
            'data' => null,
            'status' => 'error',
            'statusCode' => '404',
            'message' => 'Product Not Updated.'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'data' => $product,
                'status' => 'success',
                'statusCode' => '200',
                'message' => 'Product Deleted.'
            ], 200);
        }
        return response()->json([
            'data' => null,
            'status' => 'error',
            'statusCode' => '404',
            'message' => 'Product Not Found.'
        ], 404);
    }
}
