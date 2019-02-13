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
use think\Request;

class base extends Controller
{
    protected function _initialize()
    {
        $admin = Session::get('admin_name');
//        $name = Session::get('real_name');

        if (!$admin) {
            $this->redirect('/admin/login');
        }
    }

    public function assignRouteInfo()
    {
        $this->assign('CONTROLLER_NAME', strtolower(Request::instance()->controller()));
        $this->assign('ACTION_NAME', strtolower(Request::instance()->action()));
    }
}