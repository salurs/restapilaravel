<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    const success = 'success';
    const info = 'info';
    const warning = 'warning';
    const error = 'error';

    public function apiResponse($data, $status = self::success, $code = 200, $message = null)
    {
        $response = [
            'data' => $data,
            'status' => $status,
            'statusCode' => $code,
            'message' => $message
        ];
        return response()->json($response, $code);
    }
}

