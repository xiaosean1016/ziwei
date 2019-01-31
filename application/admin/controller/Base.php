<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/24
 * Time: 10:03
 */

namespace app\admin\controller;

use think\Controller;
use think\Session;

class base extends Controller
{
    protected function _initialize()
    {
//        $admin = Session::get(LOGIN_ADMIN);
//        if (!$admin) {
//            $this->redirect('Login/login');
//        }
    }
}