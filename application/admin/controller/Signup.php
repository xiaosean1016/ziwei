<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/24
 * Time: 15:33
 */

namespace app\admin\controller;

use think\Db;
use think\Exception;
use think\Request;

class Signup extends Base
{
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

        $templatePath = __DIR__ . '/../../config/signup_' . $id . '.html';
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
        try {
            $areaInfo = model('Field')->signArea;
            $params = Request::instance()->param();
            $params['isshow'] = $params['isshow'] == 'true' ? 1 : 0;
            $mode = $params['mode'];
            unset($params['mode']);
            $this->checkTemplateSavePermit($params);
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
            }

            return json(['code' => 'ERROR', 'msg' => 'ERROR']);
        } catch (\Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    public function checkTemplateSavePermit($params)
    {
        $cond = [];
        $cond['name'] = $params['name'];
        if ($params['id']) {
            $cond['id'] = ['<>', $params['id']];
        }
        $res = Db::name('template')->where($cond)->find();
        if ($res) {
             throw new Exception('已存在同名模板');
        }

        if ($params['id'] && !$params['isshow']) {
            $isShow = Db::name('template')->where('id', $params['id'])->value('isshow');
            if ($isShow) {
                throw new Exception('同类型模板至少保留显示一个');
            }
        }
    }

    public function saveTemplateContent()
    {
        $content = Request::instance()->param('signcontent');
        $id = Request::instance()->param('id');

        $templatePath = __DIR__ . '/../../config/signup_' . $id . '.html';
        file_put_contents($templatePath, $content);

        return json(['code' => 'SUCCESS', 'msg' => '保存成功']);
    }

    public function getFieldInfo()
    {
//        $areaInfo = model('Field')->signArea;
        $id = Request::instance()->param('id');

        $fieldInfo = Db::name('field')->find($id);

        if ($fieldInfo) {
            if ($fieldInfo['fieldtype'] == 'select' || $fieldInfo['fieldtype'] == 'multiple') {
                $pickValArr = Db::name('picklist')->where('fieldid', $id)->column('picktext', 'pickval');
                $fieldInfo['picklist'] = implode("\n", $pickValArr);
            }
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
            if ($params['fieldtype'] == 'select' || $params['fieldtype'] == 'multiple') {
                $pickVal = $params['pickval'];
                model('Field')->updatePickList($pickVal, $params['id']);
            }
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

    //获取模板对应列表配置字段
    public function getSignListConfigInfo()
    {
        $templateId = Request::instance()->param('id');
        $templateFields = model('Template')->getTemplateFields($templateId);
        $templateName = Db::name('template')->where('id', $templateId)->value('name');

        $tableFields = Db::name('field')->where('tablename', 'zw_signup')->column('fieldlabel', 'fieldname');
        $selectFields = Db::name('list_fields')->where('templateid', $templateId)->column('fieldname');

        $fields = [];
        foreach ($templateFields as $val) {
            $data = [];
            if (isset($tableFields[$val])) {
                $data['val'] = $val;
                $data['text'] = $tableFields[$val];
                $data['select'] = in_array($val, $selectFields) ? true : false;
                $fields[] = $data;
            }
        }

        return json(['code' => 'SUCCESS', 'data' => $fields, 'name' => $templateName]);
    }

    //保存列表配置字段
    public function saveListFields()
    {
        $templateId = Request::instance()->param('id');
//        $fields = Request::instance()->param('fields');
        $fields = $_REQUEST['fields'];

        Db::startTrans();

        try {
            Db::name('list_fields')->where('templateid', $templateId)->delete();

            $data = [];
            $i = 1;
            foreach ($fields as $val) {
                $data[] = [
                    'templateid' => $templateId,
                    'fieldname' => $val,
                    'sequence' => $i
                ];
                $i ++;
            }
            Db::name('list_fields')->insertAll($data);
            Db::commit();
            return json(['code' => 'SUCCESS', 'msg' => '保存成功']);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    public function signList()
    {
        $tempalteList = Db::name('template')->column('name','id');

        $this->assign('TEMPLATELIST', $tempalteList);
//        $this->assign('TEMPLATEID', key($tempalteList));
        return $this->fetch();
    }

    public function getSignList()
    {
        $templateId = Request::instance()->param('id');
        $approveStatus = Request::instance()->param('status', 'waiting');
//        $page = Request::instance()->param('page', 1);

        $listFields = Db::name('list_fields')->where('templateid', $templateId)->column('fieldname');
        $tableHeaders = Db::name('field')->where('tablename', 'zw_signup')->where('fieldname', 'IN', $listFields)->column('fieldlabel', 'fieldname');

        $listFields[] = 'createdatetime';
        $listFields[] = 'id';
        $tableHeaders['createdatetime'] = '创建时间';
        $tableHeaders['id'] = 'ID';
        if ($approveStatus != 'waiting') {
            $listFields[] = 'issentmsg';
            $listFields[] = 'msgcontent';
            $tableHeaders['issentmsg'] = '发送状态';
            $tableHeaders['msgcontent'] = '通知内容';
        }

//        $tableData = Db::name('signup')->field(implode(',', $listFields))->where('templateid', $templateId)->where('status', $approveStatus)->order('createdatetime desc')->limit(10)->page($page)->select();
        $tableData = Db::name('signup')->field(implode(',', $listFields))->where('templateid', $templateId)->where('status', $approveStatus)->order('createdatetime desc,id desc')->paginate(10);
        $statusNum = Db::name('signup')->where('templateid', $templateId)->where('status', 'not null')->group('status')->column('count(*) count', 'status');

        $data = ['table' => $tableData->items(), 'headers' => $tableHeaders, 'page' => $tableData->render(), 'num' => $statusNum];
        return json(['code' => 'SUCCESS', 'data' => $data]);
    }

    //报名表单详情
    public function showSignDetail()
    {
        $signId = Request::instance()->param('id');
        $templateId = Db::name('signup')->where('id', $signId)->value('templateid');

        $templatePath = __DIR__ . '/../../config/signup_' . $templateId . '.html';

        $templateHtml = '';
        if (file_exists($templatePath)) {
            $templateHtml = file_get_contents($templatePath);
        }
        $templateFields = model('Template')->getTemplateFields($templateId);

        $fieldsValue = Db::name('signup')->field($templateFields)->find($signId);

        $replaceData = [];
        foreach ($templateFields as $key => $val) {
            $from = "[var.{$val}]";

            $replaceData[$from] = $fieldsValue[$val];
        }

        $templateHtml = strtr($templateHtml, $replaceData);

        return json(['code' => 'SUCCESS', 'title' => $fieldsValue['name'] , 'html' => $templateHtml]);
    }

    //报名审核
    public function approveSign()
    {
        $signId = Request::instance()->param('id');
        $templateId = Request::instance()->param('templateId');
        $status = Request::instance()->param('approveRes');

        if (in_array($status, ['waiting', 'passed', 'refused'])) {
            $data['status'] = $status;
            $data['approvedatetime'] = date('Y-m-d H:i:s', time());
            Db::name('signup')->where('id', $signId)->update($data);
        }

        $statusNum = Db::name('signup')->where('templateid', $templateId)->where('status', 'not null')->group('status')->column('count(*) count', 'status');

        return json(['code' => 'SUCCESS', 'msg' => '修改成功', 'num' => $statusNum]);
    }

    //发送通知
    public function sendMessage()
    {
        $ids = Request::instance()->param('ids');
        $msgContent = Request::instance()->param('content');

        if ($ids) {
            $data['msgcontent'] = $msgContent;
            $data['issentmsg'] = 1;
            $updateRes = Db::name('signup')->where('id', 'in', $ids)->update($data);
            if ($updateRes) {
                return json(['code' => 'SUCCESS', 'msg' => '发送成功']);
            }
        }
        return json(['code' => 'ERROR', 'msg' => '无数据']);
    }
}