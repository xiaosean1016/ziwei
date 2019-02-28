<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/11
 * Time: 9:31
 */

namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        $this->assign('EMAIL', config('admin_email'));
        return $this->fetch();
    }

    public function submitLogin()
    {
        try {
            $username = Request::instance()->param('username');
            $password = Request::instance()->param('password');

            if (empty($username) || empty($password)) {
                throw new Exception('用户名密码不能为空');
            }

            $userRes = Db::name('user')->where('username', $username)->find();
            if (!$userRes) {
                throw new Exception('用户不存在');
            }

            if (!password_verify($password, $userRes['password'])) {
                throw new Exception('密码错误');
            }

            Session::set('user_id', $userRes['id']);
            Session::set('user_name', $userRes['username']);

            return json(['code' => 'SUCCESS', 'msg' => '登录成功']);

        } catch (Exception $e) {

            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }

    }
}