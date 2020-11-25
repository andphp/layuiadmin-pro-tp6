<?php
// 应用公共文件
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/11/22
 * Time: 11:37 AM
 */

/**
 * 根目录物理路径
 * @return string
 */
if(!function_exists('ap_root')){
    function ap_root()
    {
        return app()->getRootPath() . 'public';
    }
}


if(!function_exists('ap_conf')){
    /**
     * @param string $name
     * @return string
     */
    function ap_conf(string $name):string
    {
        $cacheValue =  \think\facade\Cache::get($name);
        if(!$cacheValue){
            $cacheValue = \app\admin\model\ManageConfigs::where('name',$name)->value('value');
            \think\facade\Cache::tag('config')->set($name,$cacheValue,3600);
        }
        return $cacheValue;
    }
}
