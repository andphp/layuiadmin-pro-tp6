<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/20
 * Time: 12:13 AM
 */

namespace app\admin\exception;


use app\exception\BasicException;

class TestException extends BasicException
{
    protected $code = 200;
    protected $errorCode = 553;
    protected $message = 'Systemddd unknown error !';
}