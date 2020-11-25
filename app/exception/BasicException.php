<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/19
 * Time: 2:28 AM
 */

namespace app\exception;


use app\constants\Constants;
use app\constants\ReturnCode;
use think\Exception;

class BasicException extends Exception
{
    protected $code = Constants::CLIENT_ERROR;
    protected $errorCode = ReturnCode::UNKNOWN_ERROR;
    protected $message = 'System unknown error !';

    public function __construct(array $params =[])
    {
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('message',$params)){
            $this->message = $params['message'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }

    final public function getErrorCode()
    {
        return $this->errorCode;
    }

}