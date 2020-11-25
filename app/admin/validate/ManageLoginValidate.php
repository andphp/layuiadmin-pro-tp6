<?php
declare (strict_types = 1);

namespace app\admin\validate;

use app\validate\BasicValidate;

class ManageLoginValidate extends BasicValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha|验证码'=>'require|captcha'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '用户名必填',
        'password.require' => '密码必填',
    ];
}
