<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\ManageDepartments;
use app\admin\validate\DepartmentSaveValidate;
use app\constants\ReturnCode;
use app\validate\IdValidate;
use think\Request;

class DepartmentController extends AdminController
{
    /**
     * 显示资源列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $departmentsList = (new ManageDepartments())->getList();
        // 缓存 todo
        return $this->success($departmentsList->toArray());
    }

    public function select()
    {
        $menus = (new ManageDepartments())-> getSelectList();
        return $this->success($menus);
    }

    /**
     * 保存 资源
     * @param \think\Request $request
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function save(Request $request)
    {
        //参数验证
        $params = (new DepartmentSaveValidate())->validate();
        $params['creator_id'] = $request->loginId;
        //判断 新增or更新
        if (isset($params['id']) && $params['id'] > 0) {
            //更新
            ManageDepartments::update($params);
        } else {
            //新增
            ManageDepartments::create($params);
        }
        return $this->success();
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
        $menu = (new ManageDepartments())->find($params['id']);
        //软删除
        $isDel = $menu->delete();
        if($isDel){
            return $this->success([],'删除成功！');
        }
        return $this->error(ReturnCode::DELETE_FAILED);
    }
}
