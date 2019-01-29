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
        $templateHtml = '';
        if (file_exists($templatePath)) {
            $templateHtml = file_get_contents($templatePath);
        }

        $fieldList = $this->getSignFieldsList();

        $this->assign('TEMPLATEID', $id);
        $this->assign('TEMPLATENAME', $templateName);
        $this->assign('TEMPLATEHTML', $templateHtml);
        $this->assign('FIELDLIST', $fieldList);
        return $this->fetch();
    }

    public function signTemplateList()
    {
        return $this->fetch();
    }

    public function ajax_templateList()
    {
        $list = Db::name('template')->select();

        return json($list);
    }

    public function getTemplateInfo()
    {
        $id = Request::instance()->param('id');

        $templateInfo = Db::name('template')->find($id);

        if ($templateInfo) {
            return json(['code' => 'SUCCESS', 'msg' => $templateInfo]);
        } else {
            return json(['code' => 'ERROR', 'msg' => 'ERROR']);
        }
    }

    public function saveTemplate()
    {
        $areaInfo = model('Field')->signArea;
        $params = Request::instance()->param();
        $mode = $params['mode'];
        unset($params['mode']);
        if ($mode == 'create') {
            unset($params['id']);
            $templateId = model('Template')->insertTemplate($params);
        } else {
            $updateRes = model('Template')->updateTemplate($params);
            $templateId = $updateRes ? $params['id'] : 0;
        }

        $templateInfo = Db::name('template')->find($templateId);
        if ($templateInfo) {
            $table = '';
            $table .= '<td>' . $templateInfo['id'] . '</td>';
            $table .= '<td>' . $templateInfo['name'] . '</td>';
            $table .= '<td>' . $areaInfo[$templateInfo['type']] . '</td>';
            $table .= '<td>' . $templateInfo['isshow'] . '</td>';
            $table .= '<td>' . $templateInfo['description'] . '</td>';

            return json(['code' => 'SUCCESS', 'msg' => $table, 'id' => $templateId]);
        } else {
            return json(['code' => 'ERROR', 'msg' => '保存失败']);
        }

    }

    public function saveTemplateContent()
    {
        $content = Request::instance()->param('signcontent');
        $id = Request::instance()->param('id');

        $templatePath = __DIR__ . '/../config/signup_' . $id . '.html';
        file_put_contents($templatePath, $content);

        return json(['code' => 'SUCCESS', 'msg' => '保存成功']);
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

    public function getSignFieldsList()
    {
        $list = model('Field')->getCfgFields('zw_signup');

        $data = [];
        foreach ($list as $val) {
            $vval = [$val['fieldlabel'], "[var.{$val['fieldname']}]"];
            $val['signarea'] = $val['signarea'] ?? 'common';
            $data[$val['signarea']][] = $vval;
        }

        return $data;
    }

    public function approve()
    {

    }
}