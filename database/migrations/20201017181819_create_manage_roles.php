<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManageRoles extends Migrator
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
        $table  =  $this->table('manage_roles',array('engine'=>'InnoDB'));
        $table->addColumn('role_name', 'string',array('limit'  =>  15,'default'=>'','comment'=>'角色名'))
            ->addColumn('identify', 'string',array('limit'  =>  20,'default'=>'','comment'=>'角色的英文标识'))
            ->addColumn('permissions', 'text',array('limit'  =>  \Phinx\Db\Adapter\MysqlAdapter::TEXT_REGULAR,'comment'=>'权限菜单ID'))
            ->addColumn('description', 'string',array('limit'  =>  255,'default'=>'','comment'=>'具体描述'))
            ->addColumn('creator_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'创建人ID'))
            ->addColumn('status', 'boolean',array('limit'  =>  1,'default'=>1,'comment'=>'状态 1 正常 2 停用'))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->addColumn('updated_time', 'datetime',array('default'=>null,'comment'=>'更新时间','null'=>true))
            ->addColumn('deleted_time', 'datetime',array('default'=>null,'comment'=>'删除状态，null未删除 not null 已删除','null'=>true))
            ->setComment('角色表')
            ->create();
    }
}
