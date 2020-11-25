<?php
declare (strict_types=1);

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin \think\Model
 * @property int id
 * @property varchar username	用户名，登陆使用
 * @property varchar password	用户密码
 * @property varchar email	邮箱，登陆使用
 * @property varchar avatar	用户头像
 * @property int creator_id	创建人ID
 * @property int department_id	部门ID
 * @property tinyint status	用户状态 1 正常 2 禁用
 * @property varchar login_code	排他性登陆标识
 * @property int last_login_ip	最后登录IP
 * @property datetime last_login_time	最后登录时间
 * @property datetime created_time	创建时间
 * @property datetime updated_time	更新时间
 * @property datetime deleted_time	删除状态，null未删除 not null 已删除
 * @property varchar roles	绑定角色
 */
class ManageUsers extends Model
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

    public function jobs()
    {
        return $this->hasMany(ManageUserHasJobs::class,'user_id','id');
    }

    public function manyJobs()
    {
        return $this->belongsToMany( ManageJobs::class,ManageUserHasJobs::class,'job_id','user_id');
    }

    /**
     * 获取登陆信息
     * @param $params
     * @return array|Model
     */
    public function getLoginInfoByUsernameOrEmail($params)
    {
        return $this->field('id,username,password,department_id,roles')
            ->where('username',$params['username'])
            ->whereOr('email',$params['username'])
            ->findOrEmpty();
    }

    public function scopeUsername($query,$value){
        if(!empty($value)){
            $query->where('username','like','%'.$value.'%');
        }
        $query->field('id,username,email,avatar,department_id,status,roles');
    }

    public function getRolesNameAttr(){
        $roles = self::getAttr('roles');
        return (new ManageRoles())->getRoleNameById($roles);
    }

    public function getDepartmentNameAttr(){
        $department_id = self::getAttr('department_id');
        return (new ManageDepartments())->getDepartmentNameById(strval($department_id));
    }

}
