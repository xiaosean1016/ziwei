<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/11
 * Time: 9:31
 */

namespace app\home\controller;


class Login extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}