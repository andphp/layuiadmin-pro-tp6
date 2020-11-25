<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 *
 * @property int id
 * @property varchar route	请求路由
 * @property varchar params	请求参数
 * @property int creator_id	管理员ID
 * @property varchar description	描述
 * @property varchar creator_ip	请求ip地址
 * @property datetime created_time	创建时间
 * @property datetime updated_time	更新时间
 * @property datetime deleted_time	删除状态，null未删除 not null 已删除
 */
class ManageLogs extends Model
{
    //
}
