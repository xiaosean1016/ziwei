<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/23
 * Time: 15:43
 */

namespace app\common\model;

use think\Model;
use think\db;

class Template extends Model
{
    protected $pk = 'id';

    public function insertTemplate($param)
    {
        //先将同类型其他模板不显示
        if ($param['isshow']) {
            Db::name('template')->where('type', $param['type'])->update(['isshow' => 0]);
        }
        $id = Db::name('template')->insertGetId($param);

        return $id;
    }

    public function updateTemplate($param)
    {
        if ($param) {
            $id = $param['id'];
            unset($param['id']);
            $param['isshow'] = $param['isshow'] ? 1 : 0;
            //先将同类型其他模板不显示
            if ($param['isshow']) {
                Db::name('template')->where('type', $param['type'])->update(['isshow' => 0]);
            }
            return Db::name('template')->where('id', $id)->update($param);
        }

        return false;
    }
}