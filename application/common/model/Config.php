<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/25
 * Time: 12:51
 */

namespace app\common\model;


use think\Cache;
use think\Model;

class Config extends Model
{
    protected $table = 'zw_config';
    protected $pk = 'id';

    public function getValue($key)
    {
        return $this->where('key', $key)->cache(true, 0, 'config')->value('value');
    }

    public function setValue($key, $value)
    {
        $this->where('key', $key)->update(['value' => $value]);
        Cache::clear('config');
        return true;
    }
}