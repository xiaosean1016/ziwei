<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/24
 * Time: 10:03
 */

namespace app\home\controller;

use think\Controller;
use think\Session;

class base extends Controller
{
    protected function _initialize()
    {
        $user = Session::get('user_name');

        if (!$user) {
            $this->redirect('/home/login');
        }
    }
}