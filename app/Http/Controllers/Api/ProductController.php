<?php

namespace App\Http\Controllers\Api;

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
    public function index(Request $request)
    {
//        return Product::all();
//        return response(Product::all());
//        return response()->json(Product::all());

        $offset = 10;
        if ($request->has('offset')) {
            $request->validate([
                'offset' => 'numeric|integer|min:1|max:20'
            ]);
            $offset = $request->offset;
            $data['offset'] = $request->query('offset');
        }
        $query = Product::query();
        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->query('q') . '%');
            $data['q'] = $request->query('q');
        }
        if ($request->has('sortBy') || $request->has('sort')) {
            $request->validate([
                'sortBy' => 'in:id,name,slug,price,description,created_at',
                'sort' => 'in:asc,desc'
            ]);
            $query->orderBy($request->query('sortBy'), $request->query('sort', 'desc'));
            $data['sortBy'] = $request->query('sortBy');
            $data['sort'] = $request->query('sort', 'desc');
        }

        $data['result'] = $query->paginate($offset);

        return $this->apiResponse($data, 'success', 200, 'Products list.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);
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
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $data = $request->input();
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'price' => 'sometimes|required|numeric|min:0',
                'description' => 'sometimes|required|min:3'
            ]);
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
