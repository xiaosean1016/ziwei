<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/23
 * Time: 15:51
 */

namespace app\common\model;

use think\Db;
use think\Model;

class User extends Model
{
    protected $table = 'zw_user';

    public function insertUser($data)
    {
        $filterData = ['phone', 'password', 'email'];
        foreach ($data as $key => $val) {
            if (!in_array($key, $filterData)) unset($data[$key]);
        }

        $data['username'] = $data['phone'];
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['regdatetime'] = date('Y-m-d H:i:s', time());

        if (Db::name('user')->insert($data)) {
            return true;
        }

        return false;
    }

    public function updateLastLoginTime($userId, $data)
    {
        $this->where('id', $userId)->update($data);
    }

    public function updatePassword($data)
    {
        $phone = $data['phone'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);;

        return $this->where('phone', $phone)->update(['password' => $password]);
    }
}