<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/26
 * Time: 16:46
 */

namespace app\home\controller;


class Index extends Base
{
    public function index()
    {
        $this->redirect('/home/login');
    }
}