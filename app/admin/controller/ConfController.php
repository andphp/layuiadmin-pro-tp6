<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/11/21
 * Time: 1:32 PM
 */

namespace app\admin\controller;


use app\admin\model\ManageConfigs;
use app\admin\validate\ConfigSaveValidate;
use app\constants\ReturnCode;
use think\facade\Cache;
use think\facade\Request;

class ConfController extends AdminController
{
    public function index()
    {
        $group = Request::param('group', '');
        $configName = Request::param('config_name', '');

        $where = array();
        if(trim($configName)){
            $where = [
                ['tag | name','like','%'.$configName.'%'],
            ];
        }
        $RoleModel = (new ManageConfigs());

        $role_list = $RoleModel->scope('group', $group)
            ->where($where)
            ->paginate([
                'page'      => request()->param('page'),
                'list_rows' => request()->param('limit'),
            ]);
        return $this->success($role_list->toArray());
    }

    public function group()
    {
        $group = Request::param('group', 'site');

        $ConfigModel = (new ManageConfigs());

        $config_list = $ConfigModel->field('id,name,value')->scope('group', $group)
            ->select();
        $list = array_column($config_list->toArray(),null,'name');
        return $this->success($list);
    }

    public function save()
    {
        //参数验证
        $params = (new ConfigSaveValidate())->validate();
        Cache::delete($params['name']);
        //判断 新增or更新
        if (isset($params['id']) && $params['id'] > 0) {
            //更新
            ManageConfigs::update($params);
        } else {
            //新增
            ManageConfigs::create($params);
        }
        return $this->success();
    }

    public function updateBatch()
    {
        $params = Request::param('id');
        if(!empty($params) && is_array($params)){
            Cache::tag('config')->clear();
           $upData = array_map(function($k, $v) {
                  return [
                      'id' => $k,
                      'value' => $v,
                  ];
               },
                array_keys($params),
               $params
            );
           (new ManageConfigs())->saveAll($upData);
           return $this->success();
        }
        return $this->error(ReturnCode::FILE_SAVE_ERROR);
    }

}