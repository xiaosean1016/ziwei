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
                $html = '<div class="checkbox checkbox-primary"><input id="' . $key . '" type="checkbox"><label for="' . $key . '"></label></div>';
            } elseif ($val == 'select' || $val == 'multiple') {
                $pickList = model('Field')->getPickListVal('sourcearea');
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

        $this->assign('TEMPLATEHTML', $templateHtml);
        return $this->fetch();
    }

    public function save()
    {
        $param = Request::instance()->param();

        dump($param);exit;
    }
}