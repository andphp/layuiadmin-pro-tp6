<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin \think\Model
 * @property int id
 * @property varchar department_name	部门名称
 * @property varchar identify	英文标识
 * @property int parent_id	父级ID
 * @property varchar principal	负责人
 * @property varchar mobile	联系电话
 * @property varchar email	联系邮箱
 * @property int creator_id	创建人ID
 * @property tinyint status	状态 1 正常 2 停用
 * @property int sort	排序字段
 * @property datetime created_time	创建时间
 * @property datetime updated_time	更新时间
 * @property datetime deleted_time	删除状态，null未删除 not null 已删除
 * @property varchar roles	绑定角色
 */
class ManageDepartments extends Model
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

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
    public function open()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function getList(){
        $menus = self::with([
                'parent' => function ($query) {
                    $query->field('id,department_name');
                }
            ])
            ->withCount([
                'open' => function ($query, &$alias) {
                    $alias = 'open';
                }
            ])
            ->append(['roles_name'])
            ->order('id', 'asc')
            ->order('sort', 'desc')
            ->select();

        return $menus;
    }

    /**
     * 获取 菜单父级 选择列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSelectList()
    {
        $rawMenus = self::field('id,department_name as title,identify,parent_id')
            ->order('id', 'asc')
            ->order('sort', 'desc')
            ->select();
        $newMenus = self::formatSelectList($rawMenus->toArray());
        return $newMenus;
    }

    /**
     * 格式化 菜单父级 选择列表
     * @param array $rawMenus
     * @param array $newMenus
     * @param int $id
     * @return array
     */
    protected function formatSelectList(array $rawMenus, $newMenus = [], $id = 0)
    {
        foreach ($rawMenus as $value) {
            if ($value['parent_id'] === $id) {
                $newMenu = self::formatSelectList($rawMenus, $value, $value['id']);
                if ($id == 0) {
                    $newMenus[] = $newMenu;
                } else {
                    $newMenus['children'][] = $newMenu;
                }
            }
        }
        return $newMenus;
    }

    public function getRolesNameAttr(){
        $roles = self::getAttr('roles');
        return (new ManageRoles())->getRoleNameById($roles);
    }

    public function getDepartmentNameById($id){
        if(is_array($id)){
            $id = implode(',',$id);
        }
        $department_name= self::whereIn('id',$id)->column('department_name');
        return $department_name;
    }
}
