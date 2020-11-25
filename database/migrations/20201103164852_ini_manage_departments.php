<?php

use think\migration\Migrator;
use think\migration\db\Column;

class IniManageDepartments extends Migrator
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
    public function up()
    {
        $data = array (
            0 =>
                array (
                    'id' => 1,
                    'department_name' => '北京总部',
                    'identify' => 'beijing',
                    'parent_id' => 0,
                    'principal' => '张三',
                    'mobile' => '13233443322',
                    'email' => 'test@qq.com',
                    'creator_id' => 0,
                    'status' => 1,
                    'sort' => 0,
                    'roles' => '1',
                ),
            1 =>
                array (
                    'id' => 2,
                    'department_name' => '华中总部',
                    'identify' => 'huazhong',
                    'parent_id' => 0,
                    'principal' => '小李',
                    'mobile' => '13534322233',
                    'email' => '13534322233@qq.com',
                    'creator_id' => 1,
                    'status' => 1,
                    'sort' => 0,
                    'roles' => '1,2',
                ),
            2 =>
                array (
                    'id' => 3,
                    'department_name' => '西南总部',
                    'identify' => 'xinan',
                    'parent_id' => 0,
                    'principal' => '李si',
                    'mobile' => '13534322233',
                    'email' => '123@qq.com',
                    'creator_id' => 0,
                    'status' => 1,
                    'sort' => 0,
                    'roles' => '3,4',
                ),
            3 =>
                array (
                    'id' => 4,
                    'department_name' => '海南分部',
                    'identify' => 'hainan',
                    'parent_id' => 0,
                    'principal' => 'xiaoliu',
                    'mobile' => '13324235533',
                    'email' => '',
                    'creator_id' => 0,
                    'status' => 1,
                    'sort' => 0,
                    'roles' => '2,3',
                ),
            4 =>
                array (
                    'id' => 5,
                    'department_name' => '北京一区',
                    'identify' => 'beiyiqu',
                    'parent_id' => 1,
                    'principal' => 'wangwu',
                    'mobile' => '13324234455',
                    'email' => '',
                    'creator_id' => 0,
                    'status' => 1,
                    'sort' => 0,
                    'roles' => '',
                ),
            5 =>
                array (
                    'id' => 6,
                    'department_name' => '苏州制造',
                    'identify' => 'suzhou',
                    'parent_id' => 4,
                    'principal' => 'susan',
                    'mobile' => '13324235533',
                    'email' => '',
                    'creator_id' => 1,
                    'status' => 1,
                    'sort' => 0,
                    'roles' => '2,1',
                ),
        );
        $this->table('manage_departments')->insert($data)->saveData();
    }
}
