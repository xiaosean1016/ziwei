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
    public function selectProcess()
    {
        $list = Db::name('template')->where('isshow', 1)->column('id', 'type');

        $this->assign('LIST', $list);
        return $this->fetch();
    }

    public function createView()
    {
        $id = Request::instance()->get('id');

//        $templateName = Db::name('template')->where('id', $id)->value('name');

        $templateHtml = $this->getTemplateHtml($id);

        $this->assign('TEMPLATEID', $id);
        $this->assign('TEMPLATEHTML', $templateHtml);
        return $this->fetch();
    }

    public function save()
    {
        $id = Request::instance()->param('id');
        $fields = model('Template')->getTemplateFields($id);
        $param = Request::instance()->only($fields);
        $param['createdatetime'] = date('Y-m-d H:i:s', time());
        $param['status'] = 'waiting';
        $param['templateid'] = $id;
        $param['userid'] = 1;

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

    public function editSave() {
        $id = Request::instance()->param('id');

        //todo 判断id是否为用户所属
        $templateId = Db::name('signup')->where('id', $id)->value('templateid');
        $fields = model('Template')->getTemplateFields($templateId);
        $param = Request::instance()->only($fields);

        try {
            Db::name('signup')->where('id', $id)->update($param);
            return json(['code' => 'SUCCESS', 'msg' => '修改成功']);
        } catch (\Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    public function submitResult()
    {
        $userId = Session::get('user_id');
        $userId = 2;

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

    public function editView()
    {
        $id = Request::instance()->param('id');

        $templateId = Db::name('signup')->where('id', $id)->value('templateid');

        $templateHtml = $this->getTemplateHtml($templateId);

        $this->assign('SIGNID', $id);
        $this->assign('TEMPLATEHTML', $templateHtml);
        return $this->fetch();
    }

    public function getEditValue()
    {
        $id = Request::instance()->param('id');

        $templateId = Db::name('signup')->where('id', $id)->value('templateid');
        $templateFields = model('Template')->getTemplateFields($templateId);

        $list = Db::name('signup')->field($templateFields)->where('id', $id)->find();

        return json(['code' => 'SUCCESS', 'data' => $list]);
    }
}