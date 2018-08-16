<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/16
 * Time: 11:23
 */

namespace App\Traits;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    /**
     * @var int HTTP code
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @Describe: get the HTTP code
     * @Author: chinwe.jing
     * @Data: 2018/8/16 11:32
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @Describe: set the HTTP code
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:00
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @Describe: response信息返回
     * @Author: chinwe.jing
     * @Data: 2018/8/16 11:27
     * @param $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data, $header = [])
    {
        return response::json($data, $this->getStatusCode(), $header);
    }

    /**
     * @Describe: response a no content response.
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:02
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent()
    {
        return response::json(null, FoundationResponse::HTTP_NO_CONTENT);
    }

    /**
     * @Describe: response a Request format error!
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:09
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($message = 'Request format error!', $code = FoundationResponse::HTTP_BAD_REQUEST)
    {
        return $this->setStatusCode($code)->response(['message' => $message]);
    }

    /**
     * @Describe: response a not found!
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:12
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFond($message = 'not found!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND);
    }

    /**
     * @Describe: response a validation error!
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:13
     * @param array $error
     * @return \Illuminate\Http\JsonResponse
     */
    public function fromError($error = [])
    {
        return $this->setStatusCode(422)->response(['message' => "The given data was invalid.", 'error' => $error]);
    }

    /**
     * @Describe: response a Interface requests are too frequent!
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:14
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestsMany($message = 'Interface requests are too frequent!')
    {
        return $this->failed($message, 429);
    }

    /**
     * @Describe: response the error of 'Unauthorized'.
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:15
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->failed($message, 401);
    }

    /**
     * @Describe: response No access
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:16
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notAccess($message = 'No access!')
    {
        return $this->failed($message, 403);
    }

    /**
     * @Describe: response a network error!
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:16
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function internalError($message = "network error!")
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * @Describe: 执行成功
     * @Author: chinwe.jing
     * @Data: 2018/8/16 14:16
     * @param $data
     * @param int $code
     * @param array $header
     * @return mixed
     */
    public function success($data, $code = FoundationResponse::HTTP_CREATED, $header = [])
    {
        $data = is_string($data) ? ['message' => $data] : $data;

        return $this->setStatusCode($code)->response($data, $header);
    }
}