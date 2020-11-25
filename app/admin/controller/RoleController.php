<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\admin\model\ManageRoles;
use app\constants\ReturnCode;
use app\validate\IDsValidate;
use app\validate\IdValidate;
use app\admin\validate\RoleSaveValidate;
use think\facade\Request;

class RoleController extends AdminController
{
    /**
     * 获取 列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $roleName = Request::param('role_name', '');

        $RoleModel = (new ManageRoles());

        $role_list = $RoleModel->scope('roleName', $roleName)
            ->paginate([
                'page'      => request()->param('page'),
                'list_rows' => request()->param('limit'),
            ]);
        return $this->success($role_list->toArray());
    }

    /**
     * 保存 角色
     * @param \think\Request $request
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function save(\think\Request $request)
    {
        //参数验证
        $params = (new RoleSaveValidate())->validate();
        $params['creator_id'] = $request->loginId;
        //判断 新增or更新
        if (isset($params['id']) && $params['id'] > 0) {
            //更新
            ManageRoles::update($params);
        } else {
            //新增
            ManageRoles::create($params);
        }
        return $this->success();
    }

    /**
     * 删除指定资源
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
        $menu = (new ManageRoles())->find($params['id']);
        //软删除
        $isDel = $menu->delete();
        if ($isDel) {
            return $this->success([], '删除成功！');
        }
        return $this->error(ReturnCode::DELETE_FAILED);
    }

    /**
     * 批量 删除
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function deleteBatch()
    {
        //参数验证
        $params = (new IDsValidate())->validate();
        //软删除
        $isDel = ManageRoles::destroy($params['ids']);
        if ($isDel) {
            return $this->success([], '删除成功！');
        }
        return $this->error(ReturnCode::DELETE_FAILED);
    }

    /**
     * 批量 成功
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function updateStatusBatch()
    {
        //参数验证
        $params = (new IDsValidate())->validate();
        $roleModel = new ManageRoles();

        $isUpdate = $roleModel->saveAll($params['ids']);
        if ($isUpdate) {
            return $this->success([], '批量更新成功！');
        }
        return $this->error(ReturnCode::SAVE_FAILED);
    }

    public function select()
    {
        $menus = (new ManageRoles())-> getSelect();
        return $this->success($menus->toArray());
    }

}
