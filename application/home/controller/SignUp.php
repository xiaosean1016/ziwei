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

class Signup extends Base
{
    public function createView()
    {
        $id = Request::instance()->get('id');

//        $templateName = Db::name('template')->where('id', $id)->value('name');

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
                $html = '<input type="text" placeholder="yyyy-mm-dd" data-mask="9999-99-99" class="form-control">';
            } elseif ($val == 'datetime') {
                $html = '<input type="text" placeholder="yyyy-mm-dd HH:ii:ss" data-mask="9999-99-99 99:99:99" class="form-control">';
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
}