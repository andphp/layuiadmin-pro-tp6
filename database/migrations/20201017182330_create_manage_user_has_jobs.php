<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManageUserHasJobs extends Migrator
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
        $table  =  $this->table('manage_user_has_jobs',array('engine'=>'InnoDB'));
        $table->addColumn('user_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'管理员ID'))
            ->addColumn('job_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'岗位ID'))
            ->setComment('管理员/岗位关系表')
            ->create();
    }
}
