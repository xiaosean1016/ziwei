<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/11
 * Time: 9:31
 */

namespace app\home\controller;


use think\Controller;
use think\Request;

class Register extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function sendVerifyCode()
    {

    }

    public function ajaxSubmit()
    {
        $phone = Request::instance()->param('phone');
        $password = Request::instance()->param('password');
        $verifyCode = Request::instance()->param('code');
    }
}