<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 *
 * @property int id
 * @property int role_id	角色ID
 * @property int permission_id	权限ID
 */
class ManageRoleHasPermissions extends Model
{
    //
}
