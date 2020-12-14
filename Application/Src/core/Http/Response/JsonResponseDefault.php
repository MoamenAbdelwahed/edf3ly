<?php

namespace Application\Src\Http\Response;

use Illuminate\Http\JsonResponse as Response;

/**
 * Class JsonResponseDefault
 * @package Application\Src\Http\Response
 */
class JsonResponseDefault
{
    /**
     * @param $success
     * @param $data
     * @param $message
     * @param $code
     * @return mixed
     */
    public static function create($success, $data, $message, $code)
    {
        $response = [
            'success' => $success,
            'data'  => $data,
            'message' => $message,
            'code'    => $code
        ];

        $header = [$response['code'] => $response['message']];

        return Response::create($response,$response['code'],$header);
    }
}
