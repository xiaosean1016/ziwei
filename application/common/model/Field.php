<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/1/23
 * Time: 15:43
 */

namespace app\common\model;

use think\Model;
use think\db;

class Field extends Model
{
    protected $table = 'zw_field';
    protected $pk = 'id';

    public $signArea = [
        '' => '通用',
        'local' => '本区',
        'nonlocal' => '外省'
    ];

//    public function getSignAreaAttr($value)
//    {
//        $signArea = [
//            '' => '通用',
//            'local' => '本区',
//            'nonlocal' => '外省'
//        ];
//        return $signArea[$value];
//    }


    public function getCfgFields($tablename)
    {
        $list = $this->where('tablename', $tablename)->select();

        foreach ($list as &$val) {
            $val['signarea'] = $this->signArea[$val['signarea']];
        }

        return $list;
    }

    public function insertCfgField($param)
    {
        Db::startTrans();
        try {
            $indexId = model('Config')->getValue('cfg_index');
            $newIndexId = $indexId + 1;
            model('Config')->setValue('cfg_index', $newIndexId);

            $tablename = $param['tablename'];
            $fieldname = 'cfg_' . $newIndexId;
            $fieldLabel = $param['fieldlabel'];
            $length = $param['length'];
            $fieldtype = $param['fieldtype'];

            $data = [];
            $data['tablename'] = $tablename;
            $data['fieldname'] = $fieldname;
            $data['fieldlabel'] = $fieldLabel;
            $data['presence'] = 1;
            $data['fieldtype'] = $fieldtype;
            $data['length'] = $length;

            $dataFieldType = 'varchar(200)';
            if ($fieldtype == 'date' || $fieldtype == 'datetime') {
                $dataFieldType = $fieldtype;
            } elseif ($fieldtype == 'checkbox') {
                $dataFieldType = 'tinyint(4)';
            }

            $id = $this->insertGetId($data);
            Db::execute("alter table {$tablename} add column {$fieldname} {$dataFieldType} COMMENT '{$fieldLabel}'");

            if ($param['fieldtype'] == 'select' || $param['fieldtype'] == 'multiple') {
                $pickVal = $param['pickval'];
                $this->updatePickList($pickVal, $id);
            }

            Db::commit();
            return $id;
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    public function updateCfgField($param)
    {
        if ($param) {
            $id = $param['id'];
            unset($param['id']);
            return $this->where('id', $id)->update($param);
        }

        return false;
    }

    public function updatePickList($pickVal, $fieldId)
    {
        Db::name('picklist')->where('fieldid', $fieldId)->delete();

        $pickValArr = explode("\n", $pickVal);

        $inertData = [];
        foreach ($pickValArr as $val) {
            if ($val) {
                $inertData[] = [
                    'fieldid' => $fieldId,
                    'pickval' => $val,
                    'picktext' => $val
                ];
            }
        }

        Db::name('picklist')->insertAll($inertData);
    }

    public function getPickListVal($fieldname, $tablename = 'zw_signup')
    {
        $fieldId = Db::name('field')->where('tablename', $tablename)->where('fieldname', $fieldname)->value('id');

        $pickList = Db::name('picklist')->where('fieldid', $fieldId)->column('pickval');

        return $pickList;
    }

    /**
     * @param $fields
     * @return array
     */
    public function getFieldsShowValues($fields)
    {
        //判断是一维数组
        if (count($fields) == count($fields, 1)) {
            $fieldsVal[] = $fields;
            $singleD = true;
        } else {
            $fieldsVal = $fields;
            $singleD = false;
        }

        $fieldsTypes = Db::name('field')->where('tablename', 'zw_signup')->column('fieldtype', 'fieldname');

        foreach ($fieldsVal as &$val) {
            foreach ($val as $k => &$v) {
                if (isset($fieldsTypes[$k])) {
                    $fieldType = $fieldsTypes[$k];

                    if ($fieldType == 'checkbox') {
                        $v = $v ? '是' : '否';
                    }
                    $v = $v ? $v : '';
                }
                if ($k == 'issentmsg') {
                    $v = $v ? '已通知' : '未通知';
                }
//                if ($k == 'status') {
//                    $statusView = ['waiting' => '审核中', 'passed' => '已通过', 'refused' => '已拒绝'];
//                }
            }
        }
        $fieldsVal = $singleD ? $fieldsVal[0] : $fieldsVal;

        return $fieldsVal;
    }

}