<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManagePermissions extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table  =  $this->table('manage_permissions',array('engine'=>'InnoDB'));
        $table->addColumn('name', 'string',array('limit'  =>  30,'default'=>'','comment'=>'一级菜单名称（与视图的文件夹名称和路由路径对应）'))
            ->addColumn('title', 'string',array('limit'  =>  15,'default'=>'','comment'=>'菜单名称,一级菜单标题'))
            ->addColumn('parent_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'父级ID'))
            ->addColumn('level', 'string',array('limit'  =>  50,'default'=>'','comment'=>'菜单层级'))
            ->addColumn('icon', 'string',array('limit'  =>  32,'default'=>'','comment'=>'菜单图标样式'))
            ->addColumn('jump', 'string',array('limit'  =>  50,'default'=>'','comment'=>'自定义一级菜单路由地址，默认按照 name 解析。一旦设置，将优先按照 jump 设定的路由跳转'))
            ->addColumn('spread', 'boolean',array('limit'  =>  1,'default'=>2,'comment'=>'是否默认展子菜单 1 是 2 否'))
            ->addColumn('creator_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'创建人ID'))
            ->addColumn('permission_mark', 'string',array('limit'  =>  50,'default'=>'','comment'=>'权限标识'))
            ->addColumn('permission_adopt', 'boolean',array('limit'  =>  1,'default'=>2,'comment'=>'权限全局白名单 1 是 2 否'))
            ->addColumn('type', 'boolean',array('limit'  =>  1,'default'=>1,'comment'=>'类型 1 菜单 2 按钮 3 外链'))
            ->addColumn('hidden', 'boolean',array('limit'  =>  1,'default'=>2,'comment'=>'是否隐藏 1 是 2 否'))
            ->addColumn('sort', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'排序字段'))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->addColumn('updated_time', 'datetime',array('default'=>null,'comment'=>'更新时间','null'=>true))
            ->addColumn('deleted_time', 'datetime',array('default'=>null,'comment'=>'删除状态，null未删除 not null 已删除','null'=>true))
            ->setComment('菜单/路由/权限表')
            ->create();
    }
}
