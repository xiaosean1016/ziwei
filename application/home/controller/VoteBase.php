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

class voteBase extends Controller
{
    protected function _initialize()
    {
        $user = Session::get('vote_login');

        if (request()->action() != 'login' && !$user) {
            $this->redirect('/home/vote/login');
        }
    }
}