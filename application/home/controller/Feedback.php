<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/20
 * Time: 10:15
 */

namespace app\home\controller;


use think\Controller;
use think\Db;
use think\Exception;

class Feedback extends Controller
{
<<<<<<< HEAD
=======
    public function index()
    {
        $this->redirect('create');
    }

>>>>>>> testmaster
    public function create()
    {
        return $this->fetch();
    }

    public function save()
    {
        $content = request()->param('content');
        $contact = request()->param('contact');
        $ip = request()->ip();

        try {
            if (!$content) {
                throw new Exception('反馈内容不能为空');
            }

            $data = [];
            $data['content'] = $content;
            $data['contact'] = $contact;
            $data['clientip'] = $ip;
            $data['createdatetime'] = date('Y-m-d H:i:s', time());

            if (Db::name('feedback')->insert($data)) {
                return json(['code' => 'SUCCESS', 'msg' => '提交成功']);
            }

        } catch (Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }
}