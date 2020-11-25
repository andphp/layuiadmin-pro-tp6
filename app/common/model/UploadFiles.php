<?php
declare (strict_types = 1);

namespace app\common\model;

use app\common\lib\Oss;
use app\common\lib\Qiniu;
use app\exception\UploadException;
use think\facade\Filesystem;
use think\Image;
use think\Model;

/**
 * @mixin \think\Model
 */
class UploadFiles extends Model
{
    protected $createTime = 'created_time';
    protected $autoWriteTimestamp = 'datetime';

    public function scopeFileName($query,$value){
        if(!empty($value)){
            $query->where('file_name','like','%'.$value.'%');
        }
    }

    public function uploadImg($folder_name='files',$app=1,$user_id=0)
    {
        try {
            //参数验证
            validate(['image'=>'filesize:10240|fileExt:png,jpg,jpeg,gif,bmp|image:200,200,jpg'])
                ->check(request()->file());
            $param = request()->param();
            $file = request()->file('file');
            //文件后缀名
            $ext = $file->getOriginalExtension();

            //存储类型
            $storage = ap_conf('storage');
            //数据库验证 hash
            $sha1 = $file->sha1();
            $image = self::where('hash',$sha1)->find();
            if($image){
                return $image['url'];
            }

            //图片水印处理
            if( isset($param['water']) && self::setWater($file,$param['water']) === false ) {
                throw new UploadException(['message'=>'水印配置有误']);
            }

            if( $storage==1 ) {
                //上传到阿里云oss
                $oss = new Oss();
                $file_path = $oss->putFile($file,$err);
                if( !$file_path ) {
                    throw new UploadException(['message'=>$err]);
                }
            } elseif ($storage==2){
                //上传到七牛云
                $qiniu = new Qiniu();
                $savename = date('Ymd') . '/' . md5((string) microtime(true)).'.'. $ext;
                $file_path = $qiniu->putFile($savename, $file->getRealPath());
                if( !$file_path ) {
                    throw new UploadException(['message'=>'上传失败']);
                }
            } else {

                //上传到本地服务器
                $folder = config('filesystem.disks.folder') . '/' . $folder_name; //存文件目录
                $savename = Filesystem::disk('public')->putFile($folder,$file);
                if (!$savename) {
                    throw new UploadException(['message'=>'上传失败1']);
                }
                $file_path = '/storage/' . str_replace("\\","/",$savename);

                //缩略图
                if( isset($param['thumb']) &&  $param['thumb']!='' ) {
                    self::createThumb($file,$param['thumb'],$savename);
                }
            }

            //记录入文件表
            $insert_data = [
                'url' => $file_path,
                'storage' => $storage,
                'app' => $app,
                'user_id' => intval($user_id),
                'file_name' => $file->getOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => 'image',
                'hash' => $sha1,
                'type' => 1,
                'mime' => $file->getMime(),
                'extension' => strtolower(pathinfo($file->getOriginalName(), PATHINFO_EXTENSION)),
            ];
            self::create($insert_data);

            return $file_path;
        } catch (\Exception $e) {
            throw new UploadException(['message'=>$e->getMessage()]);
        }
    }

    /**
     * 图片添加水印
     * @param $file
     * @param null $is_water
     * @return bool
     */
    public function setWater($file,$is_water=null)
    {
        if( $is_water=='0' ) {
            return true;
        }
        //图片水印
        if( ap_conf('water_img_switch')==1 || $is_water=='1' ) {
            $water_path = ap_root()."/".ltrim(ap_conf('water_img'),'/');
            if( !file_exists($water_path) ) {
                return false;
            }
            $image = Image::open($file);
            $image->water($water_path, ap_conf('water_locate'), ap_conf('water_alpha'));
            $image->save($file->getPathName());
        }
        return true;
    }

    /**
     * 生成缩略图
     * @param object $file
     * @param string $thumb 缩略图格式,如 200,200  多张用 | 好隔开
     * @param string $save_path 保存文件的路径
     * @return bool
     */
    public function createThumb($file,$thumb,$save_path)
    {
        $thumbs = explode('|',$thumb);
        foreach ($thumbs as $k => $w_h) {
            $arr = explode('.',$save_path);
            $w_h = explode(',',$w_h);
            $thumb_name = $arr[0].'_'.$w_h[0].'_'.$w_h[1].'.'.$arr[1];
            $image = Image::open($file);
            $info = $image->thumb($w_h[0],$w_h[1],3);
            $image->save(ap_root()."\\" .$thumb_name,$info->type());
        }
        return true;
    }
}
