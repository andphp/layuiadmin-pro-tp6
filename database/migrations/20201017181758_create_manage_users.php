<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManageUsers extends Migrator
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
        $table  =  $this->table('manage_users',array('engine'=>'InnoDB'));
        $table->addColumn('username', 'string',array('limit'  =>  15,'default'=>'','comment'=>'用户名，登陆使用'))
            ->addColumn('password', 'string',array('limit'  =>  60,'default'=>md5('123456'),'comment'=>'用户密码'))
            ->addColumn('email', 'string',array('limit'  =>  100,'default'=>'','comment'=>'邮箱，登陆使用'))
            ->addColumn('avatar', 'string',array('limit'  =>  255,'default'=>'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1093490743,2290792655&fm=26&gp=0.jpg','comment'=>'用户头像'))
            ->addColumn('creator_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'创建人ID'))
            ->addColumn('department_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'部门ID'))
            ->addColumn('roles', 'string',array('limit'  =>  255,'default'=>'','comment'=>'绑定角色'))
            ->addColumn('status', 'boolean',array('limit'  =>  1,'default'=>1,'comment'=>'用户状态 1 正常 2 禁用'))
            ->addColumn('login_code', 'string',array('limit'  =>  32,'default'=>0,'comment'=>'排他性登陆标识'))
            ->addColumn('last_login_ip', 'integer',array('limit'  =>  30,'default'=>0,'comment'=>'最后登录IP'))
            ->addColumn('last_login_time', 'datetime',array('default'=>null,'comment'=>'最后登录时间','null'=>true))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->addColumn('updated_time', 'datetime',array('default'=>null,'comment'=>'更新时间','null'=>true))
            ->addColumn('deleted_time', 'datetime',array('default'=>null,'comment'=>'删除状态，null未删除 not null 已删除','null'=>true))
            ->setComment('管理员表')
            ->addIndex(array('username'), array('unique'  =>  true))
            ->addIndex(array('email'), array('unique'  =>  true))
            ->create();
    }
}
