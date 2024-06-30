<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @param $key
     * @param $value
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($key, $value, $message,$code = 200){
        if(is_null($key)){
            $response = [
                'code'=>$code,
                'message' => $message,
            ];
        }else{
            $response = [
                'code'=>$code,
                $key => $value,
                'message' => $message,
            ];
        }
        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 400){
        $response = [
            'code'=>$code,
            'message' => $error,
        ];
        return response()->json($response, $code);
    }

    /**
     * Repond a no content response.
     *
     * @return response
     */
    public function noContent(){
        return response()->json(null, 204);
    }
}
