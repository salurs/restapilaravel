<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Hash;
use Str;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ]);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $newToken = Str::random(80);
                $user->update([
                    'api_token' => $newToken
                ]);
                return response()->json([
                    'name' => $user->name,
                    'token' => $newToken,
                    'time' => time(),
                ]);
            }
            return response()->json([
                'message' => 'Invalid password'
            ]);
        }
        return response()->json([
            'message' => 'User Not Found'
        ]);
    }
}
