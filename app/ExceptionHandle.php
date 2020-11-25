<?php

namespace app;

use app\constants\Constants;
use app\constants\ReturnCode;
use app\exception\BasicException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Lang;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    protected $code = Constants::SERVER_ERROR;
    protected $errorCode = ReturnCode::UNKNOWN_ERROR;
    protected $msg = 'System unknown error !';

    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
        BasicException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        $appDebug = env('APP_DEBUG', false);

        // 添加自定义异常处理机制
        if ($e instanceof BasicException) {
            $this->code = $e->getCode();
            $this->errorCode = $e->getErrorCode();
            $this->msg = $e->getMessage();
        } elseif ($appDebug) {
            return parent::render($request, $e);
        }


        if(config('app.default_return_type') === 'json')
        {
            $request = \think\facade\Request::instance();
            $result = [
                'code'        => $this->errorCode,
                'msg'         => $this->msg,
                'request_url' => $request->url(),
            ];
            return json($result, $this->code);
        }else{
            return parent::render($request, $e);
        }

        // 其他错误交给系统处理
        //return parent::render($request, $e);
    }
}
