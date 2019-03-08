<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/15
 * Time: 16:21
 */

namespace app\home\controller;

use think\Db;
use think\Model;
use think\Session;
use think\Exception;

class Vote extends VoteBase
{
    public function index()
    {
        $this->redirect('create');
    }

    public function login()
    {
        $errorMsg = '';

        if (request()->isPost()) {
            try {
                $username = request()->param('username');
                $password = request()->param('password');

                $configModel = Model('Config');

                if (empty($username) || empty($password)) {
                    throw new Exception('用户名密码不能为空');
                }

                if ($configModel->getValue('vote_username') != $username || $configModel->getValue('vote_password') != $password) {
                    throw new Exception('用户名或密码错误');
                }

                Session::set('vote_login', $username);
                $this->redirect('/home/vote/create');

            } catch (Exception $e) {
                $errorMsg = $e->getMessage();
            }
        }

        $this->assign('ERROR_MESSAGE', $errorMsg);
        return $this->fetch();
    }

    public function create()
    {
        $voteInfo = model('Vote')->getActiveVoteInfo();

//        dump($voteInfo);

        $this->assign('DATA', $voteInfo);
        if ($voteInfo) {
            return $this->fetch();
        } else {
            return $this->fetch('nothing');
        }

    }

    //投票提交
    public function submit()
    {
        $param = request()->param();
        $dateTime = date('Y-m-d H:i:s', time());
        $ip = request()->ip();

        try {
            $voteInfo = model('Vote')->getVoteInfo($param['id']);

            if (!$voteInfo) {
                throw new Exception('投票不存在');
            }
            if (!$param['checkIds']) {
                throw new Exception('请先选择投票内容');
            }
            if ($voteInfo['status'] != 'progressing') {
                throw new Exception('投票活动还未开启');
            }
            if ($dateTime < $voteInfo['startdatetime'] || $dateTime > $voteInfo['stopdatetime']) {
                throw new Exception('投票时间不在指定时间内');
            }
            //投票项数量验证
            foreach ($voteInfo['option'] as $val) {
                if ($val['full'] && in_array($val['id'], explode(',', $param['checkIds']))) {
                    throw new Exception($val['optionname'] . '投票项已经满员');
                }
            }
            //表单内容验证
            $submitField = $voteInfo['submitfield'];
            $submitRes = [];
            $submitCon = '';
            if ($submitField) {
                $fields = json_decode($submitField, true);
                foreach ($fields as $k => $v) {
                    if (!isset($param['form_' . $k])) continue;
                    if ($v['required'] && !$param['form_' . $k]) {
                        throw new Exception('表单' . $v['name'] . '字段不能为空');
                    }
                    $submitRes[] = ['name' => $v['name'], 'value' => $param['form_' . $k]];
                    $submitCon .= $param['form_' . $k];
                }
            }
            //重复投票验证
            if (!$voteInfo['submitfield']) {
                if ($ip && Db::name('vote_user')->where('voteid', $param['id'])->where('voteip', $ip)->find()) {
                    throw new Exception('请勿重复提交');
                }
            } else {
                if (Db::name('vote_user')->where('voteid', $param['id'])->where('submitcontent', $submitCon)->find()) {
                    throw new Exception('请勿重复提交');
                }
            }

            Db::startTrans();
            $voteUserData = [];
            $voteUserData['voteid'] = $param['id'];
            $voteUserData['username'] = Session::get('vote_login');
            $voteUserData['voteip'] = $ip;
            $voteUserData['submitjson'] = $submitRes ? json_encode($submitRes) : '';
            $voteUserData['submitcontent'] = $submitCon;
            $voteUserData['createdatetime'] = $dateTime;
            $voteUserId = Db::name('vote_user')->insertGetId($voteUserData);

            $voteUserOptionData = [];
            foreach (explode(',', $param['checkIds']) as $cv) {
                $voteUserOptionData[] = [
                    'voteid' => $param['id'],
                    'voteuserid' => $voteUserId,
                    'optionid' => $cv,
                ];
                Db::name('vote_option')->where('id', $cv)->setInc('optionnum');
            }
            Db::name('vote_user_option')->insertAll($voteUserOptionData);
            Db::commit();
            return json(['code' => 'SUCCESS', 'msg' => '提交成功']);
        } catch (Exception $e) {
            Db::rollback();
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }
}