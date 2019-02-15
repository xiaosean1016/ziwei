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

        $optionInfo = Db::name('vote_option')->where('id', $id)->select();

        $info = $voteInfo;
        $info['option'] = $optionInfo;
        return $info;
    }
}