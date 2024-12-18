<?php

namespace App\Helpers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ApiResponse
{
    /**
     * @param $errorsArray
     * @param $code
     * @return Response|Application|ResponseFactory
     */
    public static function errors($errorsArray =null, $code=400)
    {
        return response(['status' => false, 'message' => $errorsArray ?? __("translations.Something Went Wrong")],$code);
    }

    /**
     * @param $data
     * @param $message
     * @param $code
     * @return Response|Application|ResponseFactory
     */
    public static function data($data, $message =null, $code=200)
    {

        return response(['message'=>$message ?? __("translations.Data Retrieved Successfully"),'data' => $data,'status' => true],$code);
    }

    /**
     * @param $message
     * @param $code
     * @return Response|Application|ResponseFactory
     */
    public static function success($message =null, $code=200)
    {
        return response(['status' => true, 'message' => $message ?? __("translations.Done")],$code);
    }


}
