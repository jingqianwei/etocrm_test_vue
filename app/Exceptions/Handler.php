<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Wujunze\DingTalkException\DingTalkExceptionHelper;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        CreateCarouselErrorException::class, //自定义的错误类型
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        if(empty(env('APP_DEBUG')) && $exception->getMessage()) {
            //发邮件通知，邮件属于全文本内容
            \Mail::raw($exception . 'server:' . json_encode(\Request::server()), function ($m) {
                $m->subject('产品错误监控');
                $m->to('chinwe.jing@etocrm.com');
            });

            //钉钉消息通知
            DingTalkExceptionHelper::notify($exception, true);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * @Describe: Convert an authentication exception into a response.
     * @Author: chinwe.jing
     * @Data: 2018/8/9 18:05
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return parent::unauthenticated($request, $exception);
    }

    /**
     * @Describe: Convert a validation exception into a JSON response.
     * @Author: chinwe.jing
     * @Data: 2018/8/9 18:04
     * @param \Illuminate\Http\Request $request
     * @param ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return parent::invalidJson($request, $exception);
    }
}
