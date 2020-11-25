<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/21
 * Time: 1:44 AM
 */

namespace app\exception;


use app\constants\Constants;
use app\constants\ReturnCode;

class ValidateException extends BasicException
{
    protected $code = Constants::REQUEST_SUCCESS;
    protected $errorCode = ReturnCode::PARAM_INVALID;
    protected $message = 'Parameter validation failed !';
}