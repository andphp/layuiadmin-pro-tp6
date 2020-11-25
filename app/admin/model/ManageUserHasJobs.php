<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 *
 * @property int id
 * @property int user_id	管理员ID
 * @property int job_id	岗位ID
 */
class ManageUserHasJobs extends Model
{
    //
}
