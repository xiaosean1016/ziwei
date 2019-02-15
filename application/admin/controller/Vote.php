<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/13
 * Time: 11:09
 */

namespace app\admin\controller;


use think\Db;
use think\Exception;

class Vote extends Base
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        parent::assignRouteInfo();
    }

    //投票活动列表
    public function voteList()
    {

        return $this->fetch();
    }

    public function getVoteList()
    {
        $searchContent = request()->param('search');

        $cond = [];
        if ($searchContent) {
            $cond['votename'] = ['like', "%$searchContent%"];
        } else {
            $cond = 1;
        }

        $listFields = ['id', 'votename', 'createdatetime', 'status'];
        $tableData = Db::name('vote')->field(implode(',', $listFields))->where($cond)->order('createdatetime desc,id desc')->paginate(10);
        $listData = $this->getShowValues($tableData->items());
        $data = ['table' => $listData, 'page' => $tableData->render()];
        return json(['code' => 'SUCCESS', 'data' => $data]);
    }

    public function getShowValues($items)
    {
        $replaceData = [
            'status' => [
                'preparing' => '草稿',
                'progressing' => '进行中',
                'ending' => '已结束'
            ],
        ];

        foreach ($items as &$val) {
            foreach ($val as $k => &$v) {
                if (in_array($k, array_keys($replaceData)) && isset($replaceData[$k][$v])) {
                    $v = $replaceData[$k][$v];
                }
            }
        }

        return $items;
    }

    //选项列表
    public function optionList()
    {

    }

    //选项数据
    public function getOptionData()
    {

    }

    //新增投票活动
    public function publishView()
    {
        $this->assign('DATA', '');
        $this->assign('VOTEID', '');
        $this->assign('MODE', 'create');
        return $this->fetch();
    }

    //投票活动明细
    public function detailView()
    {
        $id = request()->param('id');
        $voteInfo = model('vote')->getVoteInfo($id);

        $this->assign('DATA', $voteInfo);
        $this->assign('VOTEID', $id);
        $this->assign('MODE', 'detail');

        return $this->fetch('publish_view');
    }

    //编辑投票活动
    public function editView()
    {
        $id = request()->param('id');
        $voteInfo = model('vote')->getVoteInfo($id);

        $this->assign('DATA', $voteInfo);
        $this->assign('VOTEID', $id);
        $this->assign('MODE', 'edit');

        return $this->fetch('publish_view');
    }

    //结束投票活动
    public function closeVote()
    {
        $id = request()->param('id');
        Db::name('vote')->where('id', $id)->update(['status' => 'ending']);
    }

    //保存投票活动
    public function saveVote()
    {
        $param = request()->param();

        $optionCount = $param['optionCount'];
        $subConCount = $param['subConCount'];
        $mode = $param['mode'];

        Db::startTrans();
        try {
            //主表字段保存
            $voteData = [];
            $voteData['votename'] = $param['voteName'];
            $voteData['startdatetime'] = $param['startTime'];
            $voteData['stopdatetime'] = $param['stopTime'];
            $voteData['votemaxballot'] = max($param['maxSelectNum'], 1);
            $voteData['status'] = $param['voteStatus'];
            $voteData['createdatetime'] = date('Y-m-d H:i:s', time());
            if ($subConCount > 0) {
                $fieldData = [];
                for ($k = 1; $k <= $subConCount; $k ++) {
                    $temp = [];
                    if (isset($param['fieldLabel_' . $k])) {
                        $temp['name'] = $param['fieldLabel_' . $k];
                        $temp['type'] = $param['fieldType_' . $k];
                        $temp['options'] = implode(',', explode('\n', $param['pickVal_' . $k]));
                        $temp['required'] = $param['isRequired_' . $k];
                        $fieldData[] = $temp;
                    }
                }
                $voteData['submitfield'] = json_encode($fieldData);
            }
            if ($mode == 'create') {
                $voteId = Db::name('vote')->insertGetId($voteData);
            } else {
                $voteId = $param['voteid'];
                Db::name('vote')->where('id', $voteId)->update($voteData);
            }

            //选项表保存
            $optionData = [];
            for ($i = 1; $i <= $optionCount; $i ++) {
                $tempData = [];
                if (isset($param['optionName_' . $i])) {
                    $tempData['voteid'] = $voteId;
                    $tempData['optionname'] = $param['optionName_' . $i];
                    $tempData['description'] = $param['optionDescription_' . $i];
                    $tempData['maxusers'] = $param['maxBallot_' . $i];
                    $tempData['optionimg'] = $param['uploadImg_' . $i];
                    $optionData[] = $tempData;
                }
            }
            if ($mode == 'edit') {
                Db::name('vote_option')->where('voteid', $voteId)->delete();
            }
            Db::name('vote_option')->insertAll($optionData);
            Db::commit();

            return json(['code' => 'SUCCESS', 'msg' => '保存成功']);
        } catch (Exception $e) {
            Db::rollback();
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    //删除投票活动
    public function deleteVote()
    {
        $id = request()->param('id');

        try {
            Db::startTrans();
            Db::name('vote')->where('id', $id)->delete();
            Db::name('vote_option')->where('voteid', $id)->delete();
            Db::commit();

            return json(['code' => 'SUCCESS', 'msg' => '删除成功']);
        } catch (Exception $e) {
            Db::rollback();
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    //投票统计数据
    public function voteStats()
    {

    }

    public function fileUpload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->validate(['size'=>1024*1024, 'ext'=>'gif,jpg,jpeg,bmp,png'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){

                return json(['code' => 'SUCCESS', 'name' => $info->getSaveName()]);
            }else{
                // 上传失败获取错误信息
                return json(['code' => 'ERROR', 'msg' => $info->getError()]);
            }
        }
    }
}