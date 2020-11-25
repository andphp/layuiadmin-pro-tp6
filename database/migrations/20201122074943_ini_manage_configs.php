<?php

use think\migration\Migrator;
use think\migration\db\Column;

class IniManageConfigs extends Migrator
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
        $data = array(
            0  =>
                array(
                    'id'          => 1,
                    'tag'         => '网站名',
                    'group'       => 'site',
                    'name'        => 'site_name',
                    'value'       => '吾与众科技',
                    'description' => '',
                ),
            1  =>
                array(
                    'id'          => 2,
                    'tag'         => 'LOGO',
                    'group'       => 'site',
                    'name'        => 'logo',
                    'value'       => '',
                    'description' => 'url',
                ),
            2  =>
                array(
                    'id'          => 3,
                    'tag'         => 'META关键词',
                    'group'       => 'site',
                    'name'        => 'keywords',
                    'value'       => 'yrds,sdfsd',
                    'description' => '',
                ),
            3  =>
                array(
                    'id'          => 4,
                    'tag'         => 'META描述',
                    'group'       => 'site',
                    'name'        => 'description',
                    'value'       => 'dd',
                    'description' => '',
                ),
            4  =>
                array(
                    'id'          => 5,
                    'tag'         => '版权信息',
                    'group'       => 'site',
                    'name'        => 'copyright',
                    'value'       => 'hjhk',
                    'description' => '',
                ),
            5  =>
                array(
                    'id'          => 6,
                    'tag'         => '存储方式',
                    'group'       => 'upload',
                    'name'        => 'storage',
                    'value'       => '2',
                    'description' => '0:本地
1:阿里oss
2:七牛云',
                ),
            6  =>
                array(
                    'id'          => 7,
                    'tag'         => 'AccessKey',
                    'group'       => 'upload',
                    'name'        => 'oss_ak',
                    'value'       => '',
                    'description' => '',
                ),
            7  =>
                array(
                    'id'          => 8,
                    'tag'         => 'AccessKeySecret',
                    'group'       => 'upload',
                    'name'        => 'oss_sk',
                    'value'       => '',
                    'description' => '阿里云oss AKS',
                ),
            8  =>
                array(
                    'id'          => 9,
                    'tag'         => 'Endpoint',
                    'group'       => 'upload',
                    'name'        => 'oss_endpoint',
                    'value'       => '',
                    'description' => '阿里oss',
                ),
            9  =>
                array(
                    'id'          => 10,
                    'tag'         => 'Bucket',
                    'group'       => 'upload',
                    'name'        => 'oss_bucket',
                    'value'       => '',
                    'description' => '阿里oss',
                ),
            10 =>
                array(
                    'id'          => 11,
                    'tag'         => 'AccessKey',
                    'group'       => 'upload',
                    'name'        => 'qiniu_ak',
                    'value'       => '',
                    'description' => '七牛云',
                ),
            11 =>
                array(
                    'id'          => 12,
                    'tag'         => 'AccessKeySecret',
                    'group'       => 'upload',
                    'name'        => 'qiniu_sk',
                    'value'       => '',
                    'description' => '七牛云',
                ),
            12 =>
                array(
                    'id'          => 13,
                    'tag'         => '域名',
                    'group'       => 'upload',
                    'name'        => 'qiniu_domain',
                    'value'       => '',
                    'description' => '七牛云',
                ),
            13 =>
                array(
                    'id'          => 14,
                    'tag'         => 'Bucket',
                    'group'       => 'upload',
                    'name'        => 'qiniu_bucket',
                    'value'       => '',
                    'description' => '七牛云',
                ),
            14 =>
                array(
                    'id'          => 15,
                    'tag'         => '水印文件路径',
                    'group'       => 'upload',
                    'name'        => 'water_img',
                    'value'       => '',
                    'description' => '不能是网络图片',
                ),
            15 =>
                array(
                    'id'          => 16,
                    'tag'         => '图片水印开关',
                    'group'       => 'upload',
                    'name'        => 'water_img_switch',
                    'value'       => '1',
                    'description' => '0:关闭
1:开启',
                ),
            16 =>
                array(
                    'id'          => 17,
                    'tag'         => '水印位置',
                    'group'       => 'upload',
                    'name'        => 'water_locate',
                    'value'       => '1',
                    'description' => '1-9',
                ),
            17 =>
                array(
                    'id'          => 18,
                    'tag'         => '水印透明度',
                    'group'       => 'upload',
                    'name'        => 'water_alpha',
                    'value'       => '50',
                    'description' => '0-100',
                ),
        );
        $this->table('manage_configs')->insert($data)->saveData();
    }
}
