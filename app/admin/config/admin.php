<?php
// +---------------------------------------------------------------------------------
// | admin [ JUST FOR API ]
// +---------------------------------------------------------------------------------
// | Copyright (c) 2017~2020 https://www.admin.org/ All rights reserved.
// +---------------------------------------------------------------------------------
// | Licensed ( https://gitee.com/admin/admin/blob/master/LICENSE.txt )
// +---------------------------------------------------------------------------------
// | Author: daxiong <417170808@qq.com>
// +---------------------------------------------------------------------------------

return [

    //鉴权相关
    'USER_ADMINISTRATOR'    => [1],

    'COMPANY_NAME'          => 'admin开发维护团队',

    //跨域配置
    'CROSS_DOMAIN'          => [
        'Access-Control-Allow-Origin'      => '*',
        'Access-Control-Allow-Methods'     => 'POST,PUT,GET,DELETE',
        'Access-Control-Allow-Headers'     => 'Version, Access-Token, User-Token, Api-Auth, User-Agent, Keep-Alive, Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With',
        'Access-Control-Allow-Credentials' => 'true'
    ],

];
