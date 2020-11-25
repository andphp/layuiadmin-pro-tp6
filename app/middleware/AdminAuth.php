<?php
declare (strict_types = 1);

namespace app\middleware;

use app\admin\service\Auth;
use app\constants\ReturnCode;
use app\exception\AuthException;
use think\facade\Cache;

class AdminAuth
{
    private $root = '/admin';
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $authorization = $request->header('authorization',null);
        // HEADER: Get the access token from the header

        if (!$authorization) {
           throw new AuthException(['message'=>'空令牌']);
        }
        $matches = array();
        if (preg_match('/Bearer\s(\S+)/', $authorization, $matches)) {
            $access_token =  $matches[1];
        }else{
            throw new AuthException(['message'=>'非法令牌']);
        }
        // 验证解密
        $userInfo = Auth::make()->verification($access_token);

        // 全局 登录id
        $request->loginId = $userInfo['data']->user_id;

        $rulesCache =  Cache::get('Login:' .$access_token,null);
        if(!$rulesCache){
            throw new AuthException(['errorCode'=>ReturnCode::ACCESS_TOKEN_TIMEOUT]);
        }
        $rulesArray = json_decode($rulesCache,true);

        $rule = str_replace('/','@',$request->pathinfo());

        // 验证路由权限
        if(!in_array($rule,$rulesArray) && !in_array($request->loginId ,config('admin.USER_ADMINISTRATOR')) ){
            throw new AuthException(['errorCode'=>ReturnCode::NO_ACCESS]);
        }
        $Response = $next($request);
        return $Response;
    }

}
