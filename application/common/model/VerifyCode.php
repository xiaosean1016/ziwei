<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/12
 * Time: 13:08
 */

namespace app\common\model;


use think\Db;
use think\Model;

class VerifyCode extends Model
{
    protected $table = 'zw_verify_code';

    public function insertVerifyCode($usage, $receiver, $code, $ip)
    {
        $data = [];

        $data['receiver'] = $receiver;
        $data['usage'] = $usage;
        $data['verifycode'] = $code;
        $data['createdatetime'] = date('Y-m-d H:i:s', time());
        $data['status'] = 'New';
        $data['clientip'] = $ip;

        return $this->insertGetId($data);
    }

    public function checkSendTimes($usage, $receiver, $date = '')
    {
        $date = $date ?: date('Y-m-d', time());
        $cond = [];
        $cond['usage'] = $usage;
        $cond['receiver'] = $receiver;
        $cond['senddatetime'] = ['>', $date];

        $count = $this->where($cond)->count();

        return $count > 3;
    }

    public function updateData($id, $data)
    {
        $this->where('id', $id)->update($data);
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