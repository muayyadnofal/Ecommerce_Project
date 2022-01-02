<?php

namespace App\Traits\HttpTraits;

trait HttpResponse
{
    public static function success($message, $status = 200): \Illuminate\Http\Response
    {
        return response([
            'success' => true,
            'message' => $message,
        ], $status);
    }

    public static function failure($message, $status = 422): \Illuminate\Http\Response
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public static function returnData($key, $value, $message): \Illuminate\Http\Response
    {
        return response([
            'success' => true,
            'message' => $message,
            $key => $value
        ]);
    }
}
