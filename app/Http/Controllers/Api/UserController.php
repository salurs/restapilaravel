<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AllIndexRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Support\Str;

class UserController extends ResponseController
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
        $query = User::query();
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
    public function store(UserStoreRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ];
        $user = User::create($data);
        if ($user) {
            return $this->apiResponse($user, 'success', 201, 'User created.');
        }
        return $this->apiResponse(null, 'error', 404, 'User not created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = User::findOrFail($id);
        if ($product) {
            return $this->apiResponse($product, 'success', 404, 'Product found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $data = $request->input();
            if ($user->update($data)) {
                return $this->apiResponse($user, self::success, 200, 'User updated.');
            }
            return $this->apiResponse(null, self::error, 404, 'User not updated.');
        }
        return $this->apiResponse(null, self::error, 404, 'User not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return $this->apiResponse($user, self::success, 200, 'User deleted.');
        }
        return $this->apiResponse(null, self::error, 404, 'User not found.');
    }
}
