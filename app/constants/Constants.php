<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/19
 * Time: 2:49 PM
 */

namespace app\constants;


class Constants
{
    /**
     * 系统服务不可用
     */
    const SERVER_ERROR = 503;

    /**
     * @Message("Token Has Expired! ")
     */
    const TOKEN_INVALID = 401;

    /**
     * 客户端错误
     */
    const CLIENT_ERROR = 403;

    /**
     * 服务器成功响应
     */
    const REQUEST_SUCCESS = 200;

    /**
     * 系统超级管理员id
     */
    const SUPER_ADMINISTRATOR_ID = 1;

    /**
     * 默认密码
     */
    const DEFAULT_PASSWORD = '123456';
}