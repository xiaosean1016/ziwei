<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{
    public function index()
    {

        $username = Request::instance()->param('username');
        $password = Request::instance()->param('password');

        if ($username && $password) {
            $userRes = Db::name('admin')->where('adminname', $username)->find();

            if ($userRes) {
                if (password_verify($password, $userRes['password']) && $userRes['status'] == 'active') {
                    Session::set('admin_name', $userRes['adminname']);
                    Session::set('real_name', $userRes['realname']);
                    $this->redirect('/admin/signup/signlist');
                }
            }
        }

        return $this->fetch();
    }

    public function logout()
    {
        Session::delete('admin_name');
        Session::delete('real_name');
        $this->redirect('/admin/login');
    }
}
