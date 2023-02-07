<?php

namespace App\Http\Controllers;



class AppBaseController extends Controller
{
    public function sendResponse($result, $message = 'Success'): \Illuminate\Http\JsonResponse
    {
        return response()->json(ResponseUtil::makeResponse($message, $result));
    }


    public function sendError($error, $code = 412): \Illuminate\Http\JsonResponse
    {
        return response()->json(ResponseUtil::makeError($error), $code);
    }
}
