<?php
declare (strict_types=1);

namespace app\admin\model;

use app\constants\StatusCode;
use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin \think\Model
 * @property int id
 * @property varchar name	一级菜单名称（与视图的文件夹名称和路由路径对应）
 * @property varchar title	菜单名称,一级菜单标题
 * @property int parent_id	父级ID
 * @property varchar level	菜单层级
 * @property varchar icon	菜单图标样式
 * @property varchar jump	自定义一级菜单路由地址，默认按照 name 解析。一旦设置，将优先按照 jump 设定的路由跳转
 * @property tinyint spread	是否默认展子菜单 1 是 2 否
 * @property int creator_id	创建人ID
 * @property varchar permission_mark	权限标识
 * @property tinyint permission_adopt	权限全局白名单 1 是 2 否
 * @property tinyint type	类型 1 菜单 2 按钮 3 外链
 * @property tinyint hidden	是否隐藏 1 是 2 否
 * @property int sort	排序字段
 * @property datetime created_time	创建时间
 * @property datetime updated_time	更新时间
 * @property datetime deleted_time	删除状态，null未删除 not null 已删除
 */
class ManagePermissions extends Model
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

    /**
     * 获取 主菜单 数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMainMenus()
    {
        $rawMenus = self::field('id,name,title,parent_id,icon,type,jump,spread,permission_mark,hidden')
            ->where('type', '<>',StatusCode::MENU_TYPE_BUTTON)
            ->order('id', 'asc')
            ->order('sort', 'desc')
            ->select();
        $newMenus = self::formatMainMenus($rawMenus->toArray());
        return $newMenus;
    }

    /**
     * 格式化（递归） 主导航
     * @param $rawMenus
     * @param array $newMenus
     * @param int $id
     * @return array
     */
    protected function formatMainMenus(array $rawMenus, $newMenus = [], $id = 0)
    {
        foreach ($rawMenus as $value) {
            if ($value['parent_id'] === $id && $value['hidden'] === StatusCode::HIDDEN_NO) {
                $newMenu = self::formatMainMenus($rawMenus, $value, $value['id']);
                unset($newMenu['hidden']);
                if ($id == 0) {
                    $newMenus[] = $newMenu;
                } else {
                    $newMenus['list'][] = $newMenu;
                }
            }
        }
        return $newMenus;
    }

    /**
     * 获取 表格展示 菜单
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMenus()
    {

        $menus = self::field("id,name,title,parent_id,icon,jump,type,spread,permission_mark,permission_adopt,hidden,sort")
            ->with([
                'parent' => function ($query) {
                    $query->field('id,title');
                }
            ])
            ->withCount([
                'open' => function ($query, &$alias) {
                    $query->where('type', '<>',StatusCode::MENU_TYPE_BUTTON);
                    $alias = 'open';
                }
            ])
            ->order('id', 'asc')
            ->order('sort', 'desc')
            ->select();

        return $menus;
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function open()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * 获取 菜单父级 选择列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSelectMenus()
    {
        $rawMenus = self::field('id,name,title,parent_id')
            ->where('type', StatusCode::MENU_TYPE_NAVIGATION)
            ->order('id', 'asc')
            ->order('sort', 'desc')
            ->select();
        $newMenus = self::formatSelectMenus($rawMenus->toArray());
        return $newMenus;
    }

    /**
     * 格式化 菜单父级 选择列表
     * @param array $rawMenus
     * @param array $newMenus
     * @param int $id
     * @return array
     */
    protected function formatSelectMenus(array $rawMenus, $newMenus = [], $id = 0)
    {
        foreach ($rawMenus as $value) {
            if ($value['parent_id'] === $id) {
                $newMenu = self::formatSelectMenus($rawMenus, $value, $value['id']);
                if ($id == 0) {
                    $newMenus[] = $newMenu;
                } else {
                    $newMenus['children'][] = $newMenu;
                }
            }
        }
        return $newMenus;
    }

    /**
     * 定义 sperad 获取器,是否默认展示子菜单
     * @param $value
     * @return mixed
     */
    public function getSpreadAttr($value)
    {
        $spread = [
            StatusCode::STATUS_NORMAL  => true,
            StatusCode::STATUS_DISABLE => false
        ];
        return $spread[$value];
    }

    /**
     * 根据父级id获取层级
     * @param $parent_id
     * @return string
     */
    public function getLevelByParentId($parent_id)
    {
        $menu = self::findOrEmpty($parent_id);
        if (!$menu->isEmpty() && !empty($menu->level)) {
            $level = $menu->level . '-' . $parent_id;
        } else {
            $level = $parent_id;
        }
        return $level;
    }

    public function getSelectAdopt()
    {
        $rawMenus = self::field('id,name,title,parent_id')
            ->where('permission_adopt', StatusCode::MENU_ADOPT_NO)
            ->order('id', 'asc')
            ->order('sort', 'desc')
            ->select();
        $newMenus = self::formatSelectAdopt($rawMenus->toArray());
        return $newMenus;
    }

    protected function formatSelectAdopt(array $rawMenus, $newMenus = [], $id = 0,$showName = '')
    {
        foreach ($rawMenus as $value) {
            if ($value['parent_id'] === $id) {
                $newMenu = self::formatSelectAdopt($rawMenus, ['value'=> $value['id'],'name'=>$value['title']], $value['id'],$value['title']);
                $newMenu['show_name'] = empty($showName)?$newMenu['name']:$showName.'-'.$newMenu['name'];
                // $newMenu['selected'] = true;
                if ($id == 0) {
                    $newMenus[] = $newMenu;
                } else {
                    $newMenus['children'][] = $newMenu;
                }
            }
        }
        return $newMenus;
    }

    /**
     * 获取 权限规则
     * @param array $data
     * @return array
     */
    public function getRules(array $data)
    {
        $rolesFromJobsArray = array();
        $rolesFromJobs = '';

        //根据部门id 获取角色
        $rolesFromDepartment = (new ManageDepartments())->where(['id'=>$data['department_id']])->value('roles');

        //根据岗位id 获取角色
        $jobsFromUserId = (new ManageUserHasJobs())->where('user_id',$data['id'])->column('job_id');

        if($jobsFromUserId){
            $rolesFromJobsArray = (new ManageJobs())->where('id','in',$jobsFromUserId)->column('roles');
        }
        if(!empty($rolesFromJobsArray)){
            $rolesFromJobs = implode(',',$rolesFromJobsArray);
        }

        //合并角色
        $rolesMerge = explode(',',$rolesFromJobs.','.$data['roles'].','.$rolesFromDepartment);
        //去空 去重
        $roles = array_unique(array_filter($rolesMerge));

        //查询路由规则
        $permissionsFromRoles= (new ManageRoleHasPermissions())->where('role_id','in',$roles)->column('permission_id');

        $wherePermission = array_unique($permissionsFromRoles);
        $permissions = (new ManagePermissions())->where('id','in',$wherePermission)->column('permission_mark');

        return array_filter($permissions);
    }
}
