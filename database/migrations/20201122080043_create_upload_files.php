<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUploadFiles extends Migrator
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

        //CREATE TABLE `w_upload_files` (
        //  `id` int(11) NOT NULL AUTO_INCREMENT,
        //  `storage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:本地，1:阿里，2:七牛',
        //  `app` tinyint(1) NOT NULL DEFAULT '0' COMMENT '来自应用 0门户 1后台',
        //  `user_id` int(20) NOT NULL DEFAULT '0' COMMENT '根据app类型判断用户类型',
        //  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
        //  `file_size` int(20) NOT NULL DEFAULT '0' COMMENT '文件大小',
        //  `extension` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀',
        //  `mime` varchar(10) NOT NULL DEFAULT '' COMMENT 'mime类型',
        //  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=未知 1=图片 2=音频 3=视频 4=附件',
        //  `hash` varchar(65) NOT NULL DEFAULT '' COMMENT '哈希值',
        //  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '图片路径',
        //  `created_time` datetime DEFAULT NULL COMMENT '创建时间',
        //  PRIMARY KEY (`id`),
        //  UNIQUE KEY `hash` (`hash`)
        //) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置表';

        $table  =  $this->table('upload_files',array('engine'=>'InnoDB'));
        $table
            ->addColumn('storage', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'0:本地，1:阿里，2:七牛'))
            ->addColumn('app', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'来自应用 0门户 1后台'))
            ->addColumn('user_id', 'integer',array('limit'  =>  20,'default'=>0,'comment'=>'根据app类型判断用户类型'))
            ->addColumn('file_name', 'string',array('limit'  =>  255,'default'=>'','comment'=>'文件名'))
            ->addColumn('file_size', 'integer',array('limit'  =>  20,'default'=>0,'comment'=>'文件大小'))
            ->addColumn('extension', 'string',array('limit'  =>  10,'default'=>'','comment'=>'文件后缀'))
            ->addColumn('mime', 'string',array('limit'  =>  10,'default'=>'','comment'=>'mime类型'))
            ->addColumn('type', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'0=未知 1=图片 2=音频 3=视频 4=附件'))
            ->addColumn('hash', 'string',array('limit'  =>  65,'default'=>'','comment'=>'哈希值'))
            ->addColumn('url', 'string',array('limit'  =>  500,'default'=>'','comment'=>'图片路径'))
            ->addColumn('created_time', 'datetime',array('default'=>null,'comment'=>'创建时间','null'=>true))
            ->setComment('配置表')
            ->addIndex(array('hash'), array('unique'  =>  true))
            ->create();
    }
}
