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

class AuthException extends BasicException
{
    protected $code = Constants::TOKEN_INVALID;
    protected $errorCode = ReturnCode::AUTH_ERROR;
    protected $message = 'Permission validation failed !';
}