<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/20
 * Time: 15:46
 */

namespace app\common\model;


use think\Db;
use think\Model;

class Signup extends Model
{
    //判断报名表数据权限
    public function checkSignPermit($signId, $userId)
    {
        $permit = false;

        $cond = [];
        $cond['id'] = $signId;
        $cond['userid'] = $userId;

        if (Db::name('signup')->where($cond)->find()) {
            $permit = true;
        }

        return $permit;
    }
}