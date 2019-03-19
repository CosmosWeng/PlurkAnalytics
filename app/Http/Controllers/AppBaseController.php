<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\ResponseUtil;
use Response;

/**
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        throw new HttpResponseException(Response::json(ResponseUtil::makeResponse($error, [], $code), $code));
    }

    public function sendPaginateResponse($result, $message)
    {
        if (array_key_exists('data', $result)) {
            $data = $result['data'];
        } else {
            $data = $result;
        }

        $response = ResponseUtil::makeResponse($message, $data);
        foreach ($result as $key => $value) {
            if ($key != 'data') {
                $response[$key] = $value;
            }
        }

        return Response::json($response);
    }
}
