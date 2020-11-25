<?php

/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/18
 * Time: 2:16 PM
 */

return [
    // key
    'key' => 'sfsggsafssfetret',
    // token
    'token' => [
        // 签发者 可选
        'iss' => '',
        // jwt所面向的用户
        'sub' => '',
        // 接收jwt的一方
        'aud' => '',
    ],
    'ttl' => 7200,
    'refresh_ttl' => (86400 * 7),
];