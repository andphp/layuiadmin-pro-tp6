<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/19
 * Time: 2:00 PM
 */

namespace app\constants;


class ReturnCode
{
    const SUCCESS = 0;

    const UNKNOWN_ERROR = 10000;        //未知错误
    const INVALID_ERROR = 10001;      //非法操作

    const RECORD_NOT_FOUND = 10002; // 记录未找到
    const SAVE_FAILED = 10003; // 更新失败
    const DELETE_FAILED = 10004; // 删除失败

    const PARAM_INVALID = 10100;     //参数验证错误
    const EMPTY_PARAMS = 10101;     //丢失必要数据

    const DB_ERROR = 10200;     //数据库操作失败
    const DB_SAVE_ERROR = 10201;
    const DB_READ_ERROR = 10202;

    const CACHE_ERROR = 10300;      //缓存
    const CACHE_SAVE_ERROR = 10301;
    const CACHE_READ_ERROR = 10302;

    const AUTH_ERROR = 10400;       //权限错误
    const LOGIN_ERROR = 10401;      //登录失败
    const ACCESS_TOKEN_TIMEOUT = 10402;
    const NO_ACCESS = 10403;

    const DATA_ERROR = 10500;       //数据错误
    const NOT_EXISTS = 10501;       //数据不存在
    const DATA_EXISTS = 10502;       //数据已经存在
    const JSON_PARSE_FAIL = 10503;      //JSON数据格式错误

    const FILE_ERROR = 10600;       //文件操作
    const FILE_SAVE_ERROR = 10601;

}