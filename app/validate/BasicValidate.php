<?php
declare (strict_types = 1);

namespace app\validate;

use app\exception\ValidateException;
use think\facade\Request;
use think\Validate;

class BasicValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    public function validate(){
        $request = Request::instance();
        $params = $request->param();
        $result = $this->check($params);

        if(!$result){
            if(is_array($this->error)){
                $msg = implode('<br>&emsp;&emsp;&emsp;&emsp;且 ',$this->error);
            }else{
                $msg = $this->error;
            }
            throw new ValidateException(['message' => $msg]);
        }
        return $params;
    }

    //预定义正则表达式
    protected $regex = ['isIntArray' => '/^(\d+(,\d+)*)?$/'];

}
