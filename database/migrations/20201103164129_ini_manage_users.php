<?php

use think\migration\Migrator;
use think\migration\db\Column;

class IniManageUsers extends Migrator
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
                    'username' => 'admin',
                    'password' => '$2y$10$XkYsvomW2JvoStgGjPexweqbj/n/NBFmGeXdDQWctvUQJiJbCyJXy',
                    'email' => 'qq@qq.com',
                    'avatar' => 'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1093490743,2290792655&fm=26&gp=0.jpg',
                    'creator_id' => 0,
                    'department_id' => 3,
                    'status' => 1,
                    'login_code' => '0',
                    'last_login_ip' => 0,
                    'last_login_time' => NULL,
                    'roles' => '1,3,2',
                ),
            );
        $this->table('manage_users')->insert($data)->saveData();
    }
}
