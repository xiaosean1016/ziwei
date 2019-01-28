<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/24
 * Time: 15:33
 */

namespace app\admin\controller;

use think\Db;
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
        $id = Request::instance()->get('id');

        $templateName = Db::name('template')->where('id', $id)->value('name');

        $templatePath = __DIR__ . '/../config/signup_' . $id . '.html';
        $templateHtml = file_get_contents($templatePath);

        $this->assign('TEMPLATEID', $id);
        $this->assign('TEMPLATENAME', $templateName);
        $this->assign('TEMPLATEHTML', $templateHtml);
        return $this->fetch();
    }

    public function saveTemplate()
    {
        $content = Request::instance()->param('signcontent');
        $id = Request::instance()->param('id');

        $templatePath = __DIR__ . '/../config/signup_' . $id . '.html';
        file_put_contents($templatePath, $content);

        return json(['code' => 'SUCCESS', 'msg' => '保存成功']);
    }

    //模板字段参照表
    public function fieldContrast()
    {
        $list = model('Field')->getCfgFields('zw_signup');

        $data = [];
        foreach ($list as $val) {
            $vval = [$val['fieldlabel'], "[var.{$val['fieldname']}]"];
            $val['signarea'] = $val['signarea'] ?? 'common';
            $data[$val['signarea']][] = $vval;
        }

        $this->assign('CONTRASTLIST', $data);
        return $this->fetch();
    }

    public function getFieldInfo()
    {
//        $areaInfo = model('Field')->signArea;
        $id = Request::instance()->param('id');

        $fieldInfo = Db::name('field')->find($id);

        if ($fieldInfo) {
//            $fieldInfo['signarea'] = $areaInfo[$fieldInfo['signarea']];
            return json(['code' => 'SUCCESS', 'msg' => $fieldInfo]);
        } else {
            return json(['code' => 'ERROR', 'msg' => 'ERROR']);
        }
    }

    public function saveField()
    {
        $areaInfo = model('Field')->signArea;
        $params = Request::instance()->param();
        $params['tablename'] = 'zw_signup';

        if ($params['type'] == 'create') {
            $fieldId = model('Field')->insertCfgField($params);
        } else {
            $updateRes = model('Field')->updateCfgField($this->getUpdateField($params));
            $fieldId = $updateRes ? $params['id'] : 0;
        }

        $fieldInfo = Db::name('field')->find($fieldId);
        if ($fieldInfo) {

            $table = '';
            $table .= '<td>' . $fieldInfo['id'] . '</td>';
            $table .= '<td>' . $fieldInfo['fieldname'] . '</td>';
            $table .= '<td>' . $fieldInfo['fieldlabel'] . '</td>';
            $table .= '<td>' . $areaInfo[$fieldInfo['signarea']] . '</td>';

            return json(['code' => 'SUCCESS', 'msg' => $table, 'id' => $fieldId]);
        } else {
            return json(['code' => 'ERROR', 'msg' => '保存失败']);
        }

    }

    public function getUpdateField($params)
    {
        $updateFields = ['id', 'fieldlabel', 'signarea'];

        $fields = [];
        foreach ($params as $key => $param) {
            if (in_array($key, $updateFields)) {
                $fields[$key] = $param;
            }
        }

        return $fields;
    }

    public function signTemplateList()
    {
        $list = Db::name('template')->select();

        $this->assign('LIST', $list);
        return $this->fetch();
    }

    public function approve()
    {

    }
}