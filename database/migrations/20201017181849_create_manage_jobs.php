<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManageJobs extends Migrator
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
        $table  =  $this->table('manage_jobs',array('engine'=>'InnoDB'));
        $table->addColumn('job_name', 'string',array('limit'  =>  15,'default'=>'','comment'=>'岗位名称'))
            ->addColumn('coding', 'string',array('limit'  =>  20,'default'=>'','comment'=>'编码,英文标识'))
            ->addColumn('creator_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'创建人ID'))
            ->addColumn('roles', 'string',array('limit'  =>  255,'default'=>'','comment'=>'绑定角色'))
            ->addColumn('status', 'boolean',array('limit'  =>  1,'default'=>1,'comment'=>'状态 1 正常 2 停用'))
            ->addColumn('sort', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'排序字段'))
            ->addColumn('description', 'string',array('limit'  =>  255,'default'=>'','comment'=>'描述'))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->addColumn('updated_time', 'datetime',array('default'=>null,'comment'=>'更新时间','null'=>true))
            ->addColumn('deleted_time', 'datetime',array('default'=>null,'comment'=>'删除状态，null未删除 not null 已删除','null'=>true))
            ->setComment('岗位表')
            ->create();
    }
}
