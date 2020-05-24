<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AllIndexRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AllIndexRequest $request)
    {
        $offset = 10;
        if ($request->has('offset')) {
            $offset = $request->offset;
            $data['offset'] = $request->query('offset');
        }
        $query = Category::query();
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

        return $this->apiResponse($data, 'success', 200, 'Users list fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ];
        $category = Category::create($data);
        if ($category) {
            return $this->apiResponse($category, self::success, 201, 'Category created.');
        }
        return $this->apiResponse(null, self::error, 404, 'Category not created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        if ($category) {
            return $this->apiResponse($category, self::success, 200, 'Category found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $data = $request->input();
            if ($request->input('name'))
                $data['slug'] = Str::slug($request->input('name'));
            if ($category->update($data)) {
                return $this->apiResponse($category, self::success, 200, 'Category updated.');
            }
            return $this->apiResponse(null, self::error, 404, 'Category not updated.');
        }
        return $this->apiResponse(null, self::error, 404, 'Category not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->apiResponse($category, self::success, 200, 'Category deleted.');
        }
        return $this->apiResponse(null, self::error, 404, 'Category not found.');
    }
}
