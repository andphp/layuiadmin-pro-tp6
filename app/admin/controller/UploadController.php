<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\lib\Oss;
use app\common\lib\Qiniu;
use app\common\model\UploadFiles;
use app\validate\IdValidate;
use think\Request;

class UploadController extends AdminController
{
    /**
     * 显示资源列表
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function index()
    {
        $fileName = \think\facade\Request::param('search_name', '');

        $uploadFileModel = (new UploadFiles());

        $file_list = $uploadFileModel->scope('fileName', $fileName)
            ->paginate([
                'page'      => request()->param('page'),
                'list_rows' => request()->param('limit'),
            ]);
        return $this->success($file_list->toArray());
    }

    /**
     * 图片上传
     * @param Request $request
     * @return \think\response\Json
     * @throws \app\exception\UploadException
     */
    public function uploadImg(Request $request)
    {
        $folder_name = $this->request->param('folder_name','images');
        $result = (new UploadFiles())->uploadImg($folder_name,1,$request->loginId);

        return $this->success(['path'=>$result]);
    }

    /**
     * 删除文件
     */
    public function delete()
    {
        //参数验证
        $params = (new IdValidate())->validate();
        $id = $params['id'];
        $file_data = UploadFiles::find($id);
        $storage = $file_data->getData('storage');
        if( $storage == 1 ) {
            $key = explode(ap_conf('oss_endpoint').'/', $file_data->url);
            //删除远程oss文件
            if( isset($key[1]) ) {
                $oss = new Oss();
                $oss->delete($key[1]);
            }
        } elseif ( $storage == 2 ) {
            //删除七牛远程文件
            $domain = ap_conf('qiniu_domain');
            $key = str_replace($domain,'',$file_data->url);
            $qiniu = new Qiniu();
            $qiniu->delete($key);
        } else {
            //删除本地服务器文件
            $file_path = ap_root()."/".ltrim($file_data->url,'/');
            if( file_exists($file_path) ) {
                unlink($file_path);
            }
        }
        UploadFiles::destroy($id);
        //todo 记录日志
        $this->success([],'删除成功');
    }

}
