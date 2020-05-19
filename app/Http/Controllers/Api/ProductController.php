<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class ProductController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductIndexRequest $request)
    {
//        return Product::all();
//        return response(Product::all());
//        return response()->json(Product::all());

        $offset = 10;
        if ($request->has('offset')) {
            $offset = $request->offset;
            $data['offset'] = $request->query('offset');
        }
        $query = Product::query();
        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->query('q') . '%');
            $data['q'] = $request->query('q');
        }
        if ($request->has('sortBy') || $request->has('sort')) {
            $query->orderBy($request->query('sortBy'), $request->query('sort', 'desc'));
            $data['sortBy'] = $request->query('sortBy');
            $data['sort'] = $request->query('sort', 'desc');
        }

        $data['result'] = $query->paginate($offset);

        return $this->apiResponse($data, 'success', 200, 'Products list fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description
        ];
        $product = Product::create($data);
        if ($product) {
            return $this->apiResponse($product, 'success', 201, 'Product created.');
        }
        return $this->apiResponse(null, 'error', 404, 'Product not created.');

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
            return $this->apiResponse($product, 'success', 200, 'Product found');
        }
        return $this->apiResponse(null, 'error', 404, 'Product not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $data = $request->input();
            if ($request->input('name'))
                $data['slug'] = Str::slug($request->input('name'));
            if ($product->update($data)) {
                return $this->apiResponse($product, self::success, 200, 'Product updated.');
            }
            return $this->apiResponse(null, self::error, 404, 'Product not updated.');
        }
        return $this->apiResponse(null, self::error, 404, 'Product not found.');

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
        if ($product) {
            $product->delete();
            return $this->apiResponse($product, 'success', 200, 'Product deleted.');
        }
        return $this->apiResponse(null, 'success', 404, 'Product not found.');
    }
}
