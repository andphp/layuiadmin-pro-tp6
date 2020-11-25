<?php
declare (strict_types = 1);

namespace app\admin\validate;


use app\validate\BasicValidate;

class JobSaveValidate extends BasicValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'job_name|岗位名称' => 'require',
        'coding|岗位编码' => 'alphaNum',
        'roles|角色绑定' => ['regex:isIntArray'],
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
