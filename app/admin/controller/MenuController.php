<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/23
 * Time: 1:01 AM
 */

namespace app\admin\controller;


use app\admin\model\ManagePermissions;
use app\constants\ReturnCode;
use app\validate\IdValidate;
use app\admin\validate\MenuSaveValidate;
use think\Request;

class MenuController extends AdminController
{

    /**
     * 主导航
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function main()
    {
        $mainMenus = (new ManagePermissions())->getMainMenus();
        // 缓存 todo
        return $this->success($mainMenus);
    }

    /**
     * 保存 菜单
     * @param Request $request
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function save(Request $request){
        //参数验证
        $params = (new MenuSaveValidate())->batch(true)->validate();
        //根据 parent_id 查询 菜单层级 level
        $params['level'] = (new ManagePermissions())->getLevelByParentId($params['parent_id']);
        //创建者
        $params['creator_id'] = $request->loginId;
        //判断 新增or更新
        if(isset($params['id']) && $params['id'] > 0){
            //更新
            ManagePermissions::update($params);
        }else{
            //新增
            ManagePermissions::create($params);
        }
        return $this->success();
    }

    /**
     * table 表格查询
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function list()
    {
        $menus = (new ManagePermissions())->getMenus();
        return $this->success($menus->toArray());
    }

    /**
     * 父级选择菜单列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $menus = (new ManagePermissions())-> getSelectMenus();
        return $this->success($menus);
    }

    /**
     * 删除
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function delete()
    {
        //参数验证
        $params = (new IdValidate())->validate();
        $menu = (new ManagePermissions())->find($params['id']);
        //软删除
        $isDel = $menu->delete();
        if($isDel){
            return $this->success([],'删除成功！');
        }
        return $this->error(ReturnCode::DELETE_FAILED);
    }

    /**
     * 权限选择
     */
    public function selectAdopt()
    {
        $menus = (new ManagePermissions())-> getSelectAdopt();
        return $this->success($menus);
    }

}