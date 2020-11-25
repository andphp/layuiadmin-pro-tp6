<?php
declare (strict_types = 1);

namespace app\admin\validate;


use app\validate\BasicValidate;

class RoleSaveValidate extends BasicValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'number',
        'role_name' => 'require',
        'permissions'=>['require','regex:isIntArray'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
