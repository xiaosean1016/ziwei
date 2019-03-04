<?php
namespace app\admin\controller;

use think\Cache;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        $errorMsg = '';

        if (Request::instance()->isPost()) {
            try {
                $username = Request::instance()->param('username');
                $password = Request::instance()->param('password');

                if (empty($username) || empty($password)) {
                    throw new Exception('用户名密码不能为空');
                }

                $userRes = Db::name('admin')->where('adminname', $username)->find();
                if (!$userRes) {
                    throw new Exception('用户不存在');
                }

                if (!password_verify($password, $userRes['password'])) {
                    throw new Exception('密码错误');
                }

                if ($userRes['status'] != 'active') {
                    throw new Exception('用户已停用');
                }

                Session::set('admin_name', $userRes['adminname']);
                Session::set('real_name', $userRes['realname']);
                $this->redirect('/admin/signup/signlist');

            } catch (Exception $e) {
                $errorMsg = $e->getMessage();
            }
        }

        $this->assign('ERROR_MESSAGE', $errorMsg);
        return $this->fetch();
    }

    public function logout()
    {
        Session::delete('admin_name');
        Session::delete('real_name');
        $this->redirect('/admin/login');
    }

    public function clearCache()
    {
        if (Cache::clear()) {
            return json(['code' => 'SUCCESS', 'msg' => '清除成功']);
        } else {
            return json(['code' => 'ERROR', 'msg' => '清除失败']);
        }
    }
}
