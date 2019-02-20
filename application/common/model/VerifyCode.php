<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/12
 * Time: 13:08
 */

namespace app\common\model;


use think\Db;

class VerifyCode
{
    public function insertVerifyCode($usage, $receiver, $code, $ip)
    {
        $data = [];

        $data['receiver'] = $receiver;
        $data['usage'] = $usage;
        $data['verifycode'] = $code;
        $data['createdatetime'] = date('Y-m-d H:i:s', time());
        $data['status'] = 'New';
        $data['clientip'] = $ip;

        return Db::name('verify_code')->insertGetId($data);
    }

    public function checkSendTimes($usage, $receiver, $date = '')
    {
        $date = $date ?: date('Y-m-d', time());
        $cond = [];
        $cond['usage'] = $usage;
        $cond['receiver'] = $receiver;
        $cond['senddatetime'] = ['>', $date];

        $count = Db::name('verify_code')->where($cond)->count();

        return $count > 3;
    }

    public function updateData($id, $data)
    {
        Db::name('verify_code')->where('id', $id)->update($data);
    }

    public function checkNewVerifyCode($usage, $receiver, $postCode)
    {
        $cond = [];
        $cond['usage'] = $usage;
        $cond['receiver'] = $receiver;
        $cond['status'] = 'New';
        $cond['senddatetime'] = ['>', date('Y-m-d H:i:s', time() - 90)];

        $res = Db::name('verify_code')->field('id,verifycode')->where($cond)->find();

        if ($res) {
            if ($res['verifycode'] != $postCode) return false;
            $this->updateData($res['id'], ['status' => 'Used']);
            return true;
        }

        return false;
    }
}