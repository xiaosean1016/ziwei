<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/13
 * Time: 11:26
 */

namespace app\common\model;

use think\Db;
use think\Model;

class Vote extends Model
{
    public function getVoteInfo($id)
    {
        $voteInfo = Db::name('vote')->where('id', $id)->find();

        $optionInfo = Db::name('vote_option')->where('voteid', $id)->select();
//        $optionNum = Db::name('vote_user_option')->field('count(*) as num,optionid')->where('voteid', $id)->group('optionid')->select();

        foreach ($optionInfo as &$val) {
            $val['full'] = $val['optionnum'] > $val['maxusers'];
        }

        $info = $voteInfo;
        $info['option'] = $optionInfo;
        return $info;
    }

    public function getActiveVoteInfo()
    {
        $voteInfo = '';
        $now = date('Y-m-d H:i:s', time());

        $cond = [];
        $cond['status'] = 'progressing';
        $cond['startdatetime'] = ['<=', $now];
        $cond['stopdatetime'] = ['>=', $now];

        $id = Db::name('vote')->where($cond)->order('createdatetime desc')->value('id');

        if ($id) {
            $voteInfo = $this->getVoteInfo($id);
        }
//        dump($voteInfo);exit;
        return $voteInfo;
    }
}