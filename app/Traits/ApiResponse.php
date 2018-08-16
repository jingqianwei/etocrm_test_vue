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
     * @Describe: response a no content response.
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
}