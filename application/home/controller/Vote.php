<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/15
 * Time: 16:21
 */

namespace app\home\controller;


use think\Controller;
use think\Session;

class Vote extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $voteUser = Session::get('vote_user');

        if (!$voteUser) {
            $this->login();
        }
    }

    public function login()
    {

    }
}