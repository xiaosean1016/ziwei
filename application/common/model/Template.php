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

class Template extends Model
{
    protected $table = 'zw_template';
    protected $pk = 'id';

    public function insertTemplate($param)
    {
        //先将同类型其他模板不显示
        if ($param['isshow']) {
            $this->where('type', $param['type'])->update(['isshow' => 0]);
        }
        $id = Db::name('template')->insertGetId($param);

        return $id;
    }

    public function updateTemplate($param)
    {
        if ($param) {
            $id = $param['id'];
            unset($param['id']);
            //先将同类型其他模板不显示
            if ($param['isshow']) {
                $this->where('type', $param['type'])->update(['isshow' => 0]);
            }
            return $this->where('id', $id)->update($param);
        }

        return false;
    }

    //获取模板所包含的字段
    public function getTemplateFields($id)
    {
        $templatePath = __DIR__ . '/../../config/signup_' . $id . '.html';
        $templateHtml = '';
        if (file_exists($templatePath)) {
            $templateHtml = file_get_contents($templatePath);
        }

        preg_match_all('/\[var\.(.*)\]/', $templateHtml, $match);
        $fields = $match[1];

        return $fields;
    }
}