<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/24
 * Time: 15:33
 */

namespace app\admin\controller;

use think\Request;

class Signup extends Base
{
    public function signList()
    {

    }

    //字段列表
    public function fieldList()
    {
        $list = model('Field')->getCfgFields('zw_signup');

        $this->assign('LIST', $list);

        return $this->fetch();
    }

    //报名表模板编辑
    public function signTemplate()
    {
        $type = Request::instance()->get('type');

        $templatePath = __DIR__ . '/../config/signup_' . $type . '.html';
        $templateHtml = file_get_contents($templatePath);

        $this->assign('TEMPLATEHTML', $templateHtml);
        $this->assign('TYPE', $type);
        return $this->fetch();
    }

    public function saveTemplate()
    {
        $content = Request::instance()->param('signcontent');
        $type = Request::instance()->param('type');

        $templatePath = __DIR__ . '/../config/signup_' . $type . '.html';
        file_put_contents($templatePath, $content);

        return json(['code' => 'SUCCESS', 'msg' => '保存成功']);
    }

    //模板字段参照表
    public function fieldContrast()
    {
        $list = model('Field')->getCfgFields('zw_signup');

        foreach ($list as $val) {
            $vval = [$val['fieldlabel'], "[var.{$val['fieldname']}]"];
            $val['signarea'] = $val['signarea'] ?? 'common';
            $data[$val['signarea']][] = $vval;
        }
        $this->assign('CONTRASTLIST', $data);
        return $this->fetch();
    }

    public function addField()
    {

    }

    public function approve()
    {

    }
}