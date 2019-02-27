<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/30
 * Time: 12:42
 */

namespace app\home\controller;

use think\Db;
use think\Exception;
use think\Model;
use think\Request;
use think\Session;

class Signup extends Base
{
    protected $isActive;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->isActive = Model('Config')->getValue('sign_active');
    }

    //选择户籍所在地页面方法
    public function selectProcess()
    {
        $list = Db::name('template')->where('isshow', 1)->column('id', 'type');

        $this->assign('LIST', $list);
        return $this->fetch();
    }

    //新增报名表方法
    public function createView()
    {
        if (!$this->isActive) {
            return $this->fetch('nothing', ['MESSAGE_TYPE' => 'end']);
        }
        $id = Request::instance()->get('id');

        //判断模板是否存在
        if (!in_array($id, model('Template')->getActiveTemplates())) {
            return $this->fetch('nothing', ['MESSAGE_TYPE' => 'none']);
        }
//        $templateName = Db::name('template')->where('id', $id)->value('name');


        $templateHtml = $this->getTemplateHtml($id);

        $this->assign('TEMPLATEID', $id);
        $this->assign('TEMPLATEHTML', $templateHtml);
        return $this->fetch();
    }

    //报名表新增保存
    public function save()
    {
        if (!$this->isActive) {
            return json(['code' => 'ERROR', 'msg' => '报名已结束']);
        }
        $id = Request::instance()->param('id');
        $fields = model('Template')->getTemplateFields($id);
        $param = Request::instance()->only($fields);
        $param['createdatetime'] = date('Y-m-d H:i:s', time());
        $param['status'] = 'waiting';
        $param['templateid'] = $id;
        $param['userid'] = Session::get('user_id');

        try {
            $signId = Db::name('signup')->insertGetId($param);

            if ($signId) {
                return json(['code' => 'SUCCESS', 'msg' => '提交成功']);
            } else {
                return json(['code' => 'ERROR', 'msg' => '提交失败']);
            }
        } catch (\Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    //提交结果列表
    public function submitResult()
    {
        $userId = Session::get('user_id');

        $list = Db::name('signup')->field('id,createdatetime,status')->where('userid', $userId)->select();

        $this->assign('LIST', $list);
        return $this->fetch();
    }

    public function getTemplateHtml($id)
    {
        $templatePath = __DIR__ . '/../../config/signup_' . $id . '.html';

        $templateHtml = '';
        if (file_exists($templatePath)) {
            $templateHtml = file_get_contents($templatePath);
        }

        $fieldList = Db::name('field')->where('tablename', 'zw_signup')->column('fieldname,fieldtype');

        $replaceData = [];
        foreach ($fieldList as $key => $val) {
            $from = "[var.{$key}]";
            $html = $from;
            if ($val == 'varchar') {
                $html = '<input class="form-control" type="text" name="' . $key . '" id="' . $key . '" value="">';
            } elseif ($val == 'date') {
                $html = '<input type="text" name="' . $key . '" id="' . $key . '" placeholder="yyyy-mm-dd" data-mask="9999-99-99" class="form-control">';
            } elseif ($val == 'datetime') {
                $html = '<input type="text" name="' . $key . '" id="' . $key . '" placeholder="yyyy-mm-dd HH:ii:ss" data-mask="9999-99-99 99:99:99" class="form-control">';
            } elseif ($val == 'checkbox') {
                $html = '<input type="checkbox" style="width: 16px" class="checkbox form-control" value="1" id="' . $key . '" name="' . $key . '">';
            } elseif ($val == 'select' || $val == 'multiple') {
                $pickList = model('Field')->getPickListVal($key);
                $html = '<select id=' . $key . ' name=' . $key . ' ' . ($val == 'multiple' ? 'multiple="multiple"' : '') . ' class="form-control">';
                foreach ($pickList as $v) {
                    $html .= '<option value="' . $v . '">' . $v . '</option>';
                }
                $html .= '</select>';
            }

            $replaceData[$from] = $html;
        }
//        $replaceInput = '<input class="form-control" type="text" name="${1}" id="${1}" value="">';
//        $templateHtml = preg_replace('/\[var\.(.*)\]/i', $replaceInput, $templateHtml);
        $templateHtml = strtr($templateHtml, $replaceData);

        return $templateHtml;
    }

    //编辑页
    public function editView()
    {
        if (!$this->isActive) {
            return $this->fetch('nothing', ['MESSAGE_TYPE' => 'end']);
        }
        $id = Request::instance()->param('id');

        $signRes = Db::name('signup')->field('templateid,status,userid')->where('id', $id)->find();

        if ($signRes) {
            if ($signRes['userid'] == $this->userId) {
                if ($signRes['status'] != 'waiting') {
                    return $this->fetch('nothing', ['MESSAGE_TYPE' => 'readonly']);
                }

                $templateId = $signRes['templateid'];
                $templateHtml = $this->getTemplateHtml($templateId);

                $this->assign('SIGNID', $id);
                $this->assign('STATUS', $signRes['status']);
                $this->assign('TEMPLATEHTML', $templateHtml);
                return $this->fetch();
            }
        }
        return $this->fetch('nothing', ['MESSAGE_TYPE' => 'none']);
    }

    //获取编辑报名表的字段值
    public function getEditValue()
    {
        $id = Request::instance()->param('id');

        $templateId = Db::name('signup')->where('id', $id)->value('templateid');
        $templateFields = model('Template')->getTemplateFields($templateId);

        $list = Db::name('signup')->field($templateFields)->where('id', $id)->find();

        return json(['code' => 'SUCCESS', 'data' => $list]);
    }

    //报名表编辑保存
    public function editSave() {
        if (!$this->isActive) {
            return json(['code' => 'ERROR', 'msg' => '报名已结束']);
        }
        $id = Request::instance()->param('id');

        $signRes = Db::name('signup')->field('templateid,status,userid')->where('id', $id)->find();

        if ($signRes) {
            if ($signRes['userid'] == $this->userId && $signRes['status'] == 'waiting') {
                $templateId = $signRes['templateid'];
                $fields = model('Template')->getTemplateFields($templateId);
                $param = Request::instance()->only($fields);

                try {
                    Db::name('signup')->where('id', $id)->update($param);
                    return json(['code' => 'SUCCESS', 'msg' => '修改成功']);
                } catch (\Exception $e) {
                    return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
                }
            }
        }

        return json(['code' => 'ERROR', 'msg' => '保存失败']);
    }
    
    //获取该用户报名次数
    public function getSignTimes()
    {
        $userId = Session::get('user_id');
        $count = 0;

        if ($userId) {
            $count = Db::name('signup')->where('userid', $userId)->count();
        }

        return $count;
    }

    //报名表单详情
    public function showSignDetail()
    {
        $signId = Request::instance()->param('id');

        $signRes = Db::name('signup')->field('templateid,status,userid')->where('id', $signId)->find();

        if (!$signRes) return json(['code' => 'ERROR', 'msg' => '数据不存在']);
        if ($signRes['userid'] != $this->userId) return json(['code' => 'ERROR', 'msg' => '数据不存在']);

        $templateId = Db::name('signup')->where('id', $signId)->value('templateid');

        $templatePath = __DIR__ . '/../../config/signup_' . $templateId . '.html';

        $templateHtml = '';
        if (file_exists($templatePath)) {
            $templateHtml = file_get_contents($templatePath);
        }
        $templateFields = model('Template')->getTemplateFields($templateId);
        $templateFields[] = 'issentmsg';
        $templateFields[] = 'msgcontent';

        $fieldsValue = Db::name('signup')->field($templateFields)->find($signId);
        $fieldsValue = model('Field')->getFieldsShowValues($fieldsValue);
        $replaceData = [];
        foreach ($templateFields as $key => $val) {
            $from = "[var.{$val}]";

            $replaceData[$from] = $fieldsValue[$val];
        }

        $templateHtml = strtr($templateHtml, $replaceData);

        $templateDesc = Db::name('template')->where('id', $templateId)->value('description');
        $msgContent = ($fieldsValue['issentmsg'] && $fieldsValue['msgcontent']) ? $fieldsValue['msgcontent'] : '';

        return json([
            'code' => 'SUCCESS',
            'title' => $fieldsValue['name'],
            'html' => $templateHtml,
            'status' => $signRes['status'],
            'description' => $templateDesc,
            'message' => $msgContent
        ]);
    }
}