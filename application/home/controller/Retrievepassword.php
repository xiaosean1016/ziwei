<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/13
 * Time: 9:46
 */

namespace app\home\controller;


use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class RetrievePassword extends Controller
{
    private $verifyCodeUsage = 'retrivepassword';

    public function index()
    {
        return $this->fetch();
    }

    //发送验证码
    public function sendVerifyCode()
    {
        $param = Request::instance()->param();
        try {
            $this->checkForm($param);
            $this->sendSmsCode($param['phone']);
            return json(['code' => 'SUCCESS', 'msg' => '发送成功']);
        } catch (\Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    //验证表单字段
    public function checkForm($param)
    {
        if (isset($param['phone'])) {
            $this->phoneNumberCheck($param['phone']);
        }

        if (isset($param['password'])) {
            $this->passwordCheck($param['password']);
        }

        if (isset($param['captcha_code'])) {
            $this->captchaCodeCheck($param['captcha_code']);
        }

        if (isset($param['verifyCode'])) {
            $this->verifyCodeCheck($param['phone'], $param['verifyCode']);
        }
    }

    //验证手机号字段
    public function phoneNumberCheck($phone)
    {
        if (empty($phone)) {
            throw new Exception('手机号不能为空$$phone');
        }

        if (!preg_match('/^1[0-9]{10}$/', $phone)) {
            throw new Exception('手机号码格式不正确$$phone');
        }

        if(!Db::name('user')->where('phone', $phone)->find()) {
            throw new Exception('账号不存在，请重新确认$$phone');
        }
    }

    //验证密码格式
    public function passwordCheck($password)
    {
        if (!preg_match('/^\w{8,20}$/', $password)) {
            throw new Exception('密码格式不正确$$password');
        }
    }

    //验证图片验证码
    public function captchaCodeCheck($captcha)
    {
        if (!captcha_check($captcha)){
            throw new Exception('图片验证码输入错误$$captcha_code');
        }
    }

    //验证短信验证码
    public function verifyCodeCheck($receiver, $verifyCode)
    {
        $res = model('VerifyCode')->checkNewVerifyCode($this->verifyCodeUsage, $receiver, $verifyCode);

        if (!$res) {
            throw new Exception('短信验证码输入错误$$verify_code');
        }
    }

    //提交
    public function submitRetrievePassword()
    {
        $param = Request::instance()->only(['phone', 'password', 'verifyCode']);

        try {
            $this->checkForm($param);
            if (model('User')->updatePassword($param['phone'], $param['password'])) {
                return json(['code' => 'SUCCESS', 'msg' => '修改成功']);
            }
            return json(['code' => 'ERROR', 'msg' => '修改失败']);
        } catch (\Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    public function sendSmsCode($receiver)
    {
        $verifyModel = model('VerifyCode');
        $dateTime = date('Y-m-d H:i:s', time());

        if ($verifyModel->checkSendTimes($this->verifyCodeUsage, $receiver)) {
            throw new Exception('验证码发送过于频繁$$verify_code');
        }

        $code = mt_rand(1000, 9999);
        $ip = Request::instance()->ip();
        $id = model('VerifyCode')->insertVerifyCode($this->verifyCodeUsage, $receiver, $code, $ip);

        if (!$id) {
            throw new Exception('insert错误');
        }

//        $result = sendMsg($receiver, $code);
        $result = 1;
        if ($result) {
            $verifyModel->updateData($id, ['senddatetime' => $dateTime]);
        }
    }
}