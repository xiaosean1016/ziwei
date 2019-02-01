<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/24
 * Time: 10:24
 */

namespace app\admin\controller;

use think\Db;

class Field extends Base
{
    public function FieldList()
    {
        $tablename = 'zw_signup';
        $list = Db::table('zw_field')->where('tablename', $tablename)->select();
        dump($list);
    }

    public function addField()
    {
        $param = [
            'tablename' => 'zw_signup',
            'fieldlabel' => 'test',
            'length' => 200
        ];

        model('Field')->insertCfgField($param);
    }
}