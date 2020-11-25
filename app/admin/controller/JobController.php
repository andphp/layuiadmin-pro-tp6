<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\ManageJobs;
use app\admin\validate\JobSaveValidate;
use app\constants\ReturnCode;
use app\validate\IDsValidate;
use app\validate\IdValidate;
use think\facade\Request;

class JobController extends AdminController
{
    /**
     * 获取 列表
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function index()
    {
        $jobName = Request::param('job_name', '');

        $JobModel = (new ManageJobs());

        $job_list = $JobModel->scope('jobName', $jobName)
            ->field(['id','job_name','coding','roles','status','description'])
            ->append(['roles_name'])
            ->paginate([
                'page'      => request()->param('page',1),
                'list_rows' => request()->param('limit',10),
            ]);

        return $this->success($job_list->toArray());
    }

    /**
     *  保存 新增/修改
     * @param \think\Request $request
     * @return \think\response\Json
     * @throws \app\exception\ValidateException
     */
    public function save(\think\Request $request)
    {
        //参数验证
        $params = (new JobSaveValidate())->validate();
        $params['creator_id'] = $request->loginId;
        //判断 新增or更新
        if(isset($params['id']) && $params['id'] > 0){
            //更新
            ManageJobs::update($params);
        }else{
            //新增
            ManageJobs::create($params);
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
        $menu = (new ManageJobs())->find($params['id']);
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
        $isDel = ManageJobs::destroy($params['ids']);
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
        $jobModel = new ManageJobs();

        $isUpdate = $jobModel->saveAll($params['ids']);
        if ($isUpdate) {
            return $this->success([], '批量更新成功！');
        }
        return $this->error(ReturnCode::SAVE_FAILED);
    }

    public function select()
    {
        $menus = (new ManageJobs())-> getSelect();
        return $this->success($menus->toArray());
    }
}
