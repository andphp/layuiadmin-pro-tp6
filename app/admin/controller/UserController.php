<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/21
 * Time: 12:31 AM
 */

namespace app\admin\controller;


use app\admin\model\ManagePermissions;
use app\admin\model\ManageUsers;
use app\admin\service\Auth;
use app\admin\validate\UserSaveValidate;
use app\constants\ReturnCode;
use app\validate\IDsValidate;
use app\validate\IdValidate;
use app\admin\validate\ManageLoginValidate;
use think\facade\Db;
use think\facade\Request;

class UserController extends AdminController
{
    /**
     * 登录
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function login()
    {

        //参数验证
        $params = (new ManageLoginValidate())->batch(true)->validate();
        //查询登陆信息
        $userModel = new ManageUsers();
        $loginInfo = $userModel->getLoginInfoByUsernameOrEmail($params);
        if (empty($loginInfo) || $loginInfo->isEmpty()) {
            return $this->error(ReturnCode::LOGIN_ERROR,lang('login_failed'));
        }
        //验证密码
        if (!password_verify($params['password'], $loginInfo['password'])) {
            return $this->error(ReturnCode::LOGIN_ERROR,lang('login_failed'));
        }

        //构建token
        $token = Auth::make()->generateToken(['user_id' => $loginInfo['id']]);

        //权限
        $rules = (new ManagePermissions())->getRules($loginInfo->toArray());
        cache('Login:' .$token['access_token'], json_encode($rules), config('admin.ACCESS_TOKEN_TIME_OUT'));
        return $this->success($token);
    }

    /**
     * 获取 列表
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function index()
    {
        $username = Request::param('username', '');

        $UserModel = (new ManageUsers());

        $user_list = $UserModel->scope('username', $username)
            ->with(['jobs'=> function($query) {
                $query->field(['user_id','job_id'])->hidden(['user_id']);
            }])
            ->append(['roles_name','department_name'])
            ->paginate([
                'page'      => request()->param('page',1),
                'list_rows' => request()->param('limit',10),
            ]);

        return $this->success($user_list->toArray());
    }

    /**
     * 保存 新增/修改
     * @param \think\Request $request
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function save(\think\Request $request)
    {
        //参数验证
        $params = (new UserSaveValidate())->validate();
        $params['creator_id'] = $request->loginId;
        //判断 新增or更新
        $ManageUsersModel = new ManageUsers();
        if(isset($params['id']) && $params['id'] > 0){
            //更新
            // 启动事务
            Db::startTrans();
            try {
                $ManageUsersModel->update($params);
                $jobData = explode(',',$params['jobs']);
                $jobUpdate = [];
                foreach ($jobData as $key => $value) {
                    $jobUpdate[$key]['user_id'] = $params['id'];
                    $jobUpdate[$key]['job_id'] = $value;
                }
                $ManageUsersModel->jobs()->where(['user_id'=>$params['id']])->delete();
                $ManageUsersModel->jobs()->saveAll($jobUpdate);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return $this->error(ReturnCode::SAVE_FAILED);
            }
        }else{
            //新增
            // 启动事务
            Db::startTrans();
            try {
                $id = $ManageUsersModel->strict(false)->insertGetId($params);
                $jobData = explode(',',$params['jobs']);
                $jobUpdate = [];
                foreach ($jobData as $key => $value) {
                    $jobUpdate[$key]['user_id'] = $id;
                    $jobUpdate[$key]['job_id'] = $value;
                }
                $ManageUsersModel->jobs()->saveAll($jobUpdate);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return $this->error(ReturnCode::SAVE_FAILED);
            }
        }
        return $this->success();
    }

    /**
     * 删除指定id
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
        $menu = (new ManageUsers())->find($params['id']);
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
        $isDel = ManageUsers::destroy($params['ids']);
        if ($isDel) {
            return $this->success([], '删除成功！');
        }
        return $this->error(ReturnCode::DELETE_FAILED);
    }

    /**
     * 批量 更新状态
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function updateStatusBatch()
    {
        //参数验证
        $params = (new IDsValidate())->validate();
        $userModel = new ManageUsers();

        $isUpdate = $userModel->saveAll($params['ids']);
        if ($isUpdate) {
            return $this->success([], '批量更新成功！');
        }
        return $this->error(ReturnCode::SAVE_FAILED);
    }
}