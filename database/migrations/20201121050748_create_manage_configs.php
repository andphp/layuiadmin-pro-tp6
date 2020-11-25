<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManageConfigs extends Migrator
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
        $table  =  $this->table('manage_configs',array('engine'=>'InnoDB'));
        $table->addColumn('tag', 'string',array('limit'  =>  15,'default'=>'','comment'=>'配置标签'))
            ->addColumn('group', 'string',array('limit'  =>  20,'default'=>'','comment'=>'分组'))
            ->addColumn('name', 'string',array('limit'  =>  50,'default'=>'','comment'=>'key'))
            ->addColumn('value', 'string',array('limit'  =>  255,'default'=>'','comment'=>'value'))
            ->addColumn('description', 'string',array('limit'  =>  255,'default'=>'','comment'=>'描述'))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->addColumn('updated_time', 'datetime',array('default'=>null,'comment'=>'更新时间','null'=>true))
            ->addColumn('deleted_time', 'datetime',array('default'=>null,'comment'=>'删除状态，null未删除 not null 已删除','null'=>true))
            ->setComment('配置表')
            ->addIndex(array('name'), array('unique'  =>  true))
            ->create();
    }
}
