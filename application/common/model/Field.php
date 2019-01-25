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
    protected $pk = 'id';

    public function getCfgFields($tablename)
    {
        $list = Db::table('zw_field')->where('tablename', $tablename)->select();
        return $list;
    }

    public function insertCfgField($param)
    {
        Db::startTrans();
        try {
            $indexId = Db::table('zw_cfg_index')->value('id');
            $newIndexId = $indexId + 1;
            Db::execute("update zw_cfg_index set id = ?", [$newIndexId]);

            $tablename = $param['tablename'];
            $fieldname = 'cfg_' . $newIndexId;
            $fieldLabel = $param['fieldlabel'];
            $length = $param['length'];

            $data = [];
            $data['tablename'] = $tablename;
            $data['fieldname'] = $fieldname;
            $data['fieldlabel'] = $fieldLabel;
            $data['presence'] = 1;
            $data['fieldtype'] = 'varchar';
            $data['length'] = $length;
            Db::table('zw_field')->insert($data);
            Db::execute("alter table {$tablename} add column {$fieldname} varchar(200) COMMENT '{$fieldLabel}'");

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }
}