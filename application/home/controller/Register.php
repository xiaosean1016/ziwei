<?php
/**
 * Created by PhpStorm.
 * User: youdone-dev
 * Date: 2019/2/11
 * Time: 9:31
 */

namespace app\home\controller;


use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class Register extends Controller
{
    private $verifyCodeUsage = 'register';

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
            $code = $this->sendSmsCode($param['phone']);
            //todo sean actual msg
//            return json(['code' => 'SUCCESS', 'msg' => '发送成功']);
            return json(['code' => 'SUCCESS', 'msg' => $code]);
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

        if(Db::name('user')->where('phone', $phone)->find()) {
            throw new Exception('该手机账号已被注册$$phone');
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

    //注册
    public function submitRegister()
    {
        $param = Request::instance()->only(['phone', 'password', 'verifyCode']);

        try {
            $this->checkForm($param);
            if (model('User')->insertUser($param)) {
                return json(['code' => 'SUCCESS', 'msg' => '注册成功']);
            }
            return json(['code' => 'ERROR', 'msg' => '注册失败']);
        } catch (\Exception $e) {
            return json(['code' => 'ERROR', 'msg' => $e->getMessage()]);
        }
    }

    public function sendSmsCode($receiver)
    {
        $verifyModel = model('VerifyCode');
        $dateTime = date('Y-m-d H:i:s', time());

        if ($verifyModel->checkSendTimes('register', $receiver)) {
            throw new Exception('验证码发送过于频繁$$verify_code');
        }

        $code = mt_rand(1000, 9999);
        $ip = Request::instance()->ip();
        $id = model('VerifyCode')->insertVerifyCode($this->verifyCodeUsage, $receiver, $code, $ip);

        if (!$id) {
            throw new Exception('insert错误');
        }

        //todo sean send SMS
//        $result = sendMsg($receiver, $code);
        $result = 1;
        if ($result) {
            $verifyModel->updateData($id, ['senddatetime' => $dateTime]);
        }

        return $code;
    }
}