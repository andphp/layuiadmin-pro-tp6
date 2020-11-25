<?php
declare (strict_types = 1);

namespace app\admin\validate;


use app\validate\BasicValidate;

class DepartmentSaveValidate  extends BasicValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'department_name|部门名称' => 'require',
        'identify' => 'alphaNum',
        'principal|负责人' => 'chsAlpha',
        'sort' => 'integer',
        'mobile|联系电话' => 'mobile',
        'email' => 'email',
        'status' => 'integer',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
