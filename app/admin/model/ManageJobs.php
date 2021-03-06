<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin \think\Model
 * @property int id
 * @property varchar job_name	岗位名称
 * @property varchar coding	编码,英文标识
 * @property int creator_id	创建人ID
 * @property varchar roles	绑定角色
 * @property tinyint status	状态 1 正常 2 停用
 * @property int sort	排序字段
 * @property varchar description	描述
 * @property datetime created_time	创建时间
 * @property datetime updated_time	更新时间
 * @property datetime deleted_time	删除状态，null未删除 not null 已删除
 */
class ManageJobs extends Model
{
    use SoftDelete;
    /**
     * 自定义添加时间字段名、更新时间字段名
     * 当取值为false时,代表关闭指定字段的自动写入
     */
    protected $createTime = 'created_time';
    protected $updateTime = 'updated_time';
    protected $deleteTime = 'deleted_time';

    //这里是必须隐藏的字段
    protected $hidden = [
        'created_time',
        'updated_time',
        'deleted_time'
    ];

    public function scopeJobName($query,$value){
    if(!empty($value)){
        $query->where('job_name','like','%'.$value.'%');
    }
}

    public function getRolesNameAttr(){
        $roles = self::getAttr('roles');
        return (new ManageRoles())->getRoleNameById($roles);
    }

    public function getSelect(){
        $selectList = self::field('id,job_name')
            ->order('id', 'desc')
            ->select();
        return $selectList;
    }
}
