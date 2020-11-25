<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateManageLogs extends Migrator
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

        // `id` int(10) NOT NULL AUTO_INCREMENT,
        //  `module` varchar(20) DEFAULT NULL COMMENT '模块',
        //  `controller` varchar(20) DEFAULT NULL COMMENT '控制器',
        //  `action` varchar(20) NOT NULL DEFAULT '' COMMENT '方法',
        //  `param` varchar(100) NOT NULL DEFAULT '' COMMENT '参数',
        //  `describe` varchar(100) NOT NULL COMMENT '更新描述',
        //  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
        //  `add_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '操作IP',
        //  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '操作时间',
        //  PRIMARY KEY (`id`)
        $table  =  $this->table('manage_logs',array('engine'=>'InnoDB'));
        $table->addColumn('route', 'string',array('limit'  =>   50,'default'=>'','comment'=>'请求路由'))
            ->addColumn('params', 'string',array('limit'  =>  20,'default'=>'','comment'=>'请求参数'))
            ->addColumn('creator_id', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'管理员ID'))
            ->addColumn('description', 'string',array('limit'  =>  255,'default'=>'','comment'=>'描述'))
            ->addColumn('creator_ip', 'string',array('limit'  =>  30,'default'=>'','comment'=>'请求ip地址'))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->addColumn('updated_time', 'datetime',array('default'=>null,'comment'=>'更新时间','null'=>true))
            ->addColumn('deleted_time', 'datetime',array('default'=>null,'comment'=>'删除状态，null未删除 not null 已删除','null'=>true))
            ->setComment('管理员操作日志表')
            ->create();
    }
}
