<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 11:14
 */
namespace app\admin\controller;

use think\Controller;

class Login extends Controller{
    /**
     * 空操作
     *
     */
    public function _empty(){
        echo  '网址输入错误';
        exit;
    }

    public function index(){
        return $this->fetch("login");
    }

    public function login(){
        $data = [
            'username'=>input('username'),
            'password'=>input('password'),
            'code'=>input('code'),
        ];
        session_start();
        //验证验证码
        if($data['code'] == ''|| !$data['code']){
            return $this->error('验证码不能为空');
        }
        //判断验证码是否正确
        if(!captcha_check($data['code'])){
            return $this->error('验证码错误');
        }
        //验证用户名
        if($data['username'] == ''|| !$data['username']){
            return $this->error('用户名不能为空');
        }
        //验证密码
        if($data['username'] == ''|| !$data['username']){
            return $this->error('密码不能为空');
        }
        //判断用户名是否存在
        $arr = db('admin')->where(['username'=>$data['username']])->find();
        if(!$arr){
            return $this->error('用户名或密码错误');
        }
        if($arr['password'] != md5($data['password'])){
            return $this->error('用户名或密码错误');
        }if($arr['state'] != 0) {
            return $this->error('该管理员账号已被冻结');
        }
        //登录成功以后，把用户信息放在session里面
        session('admin',$arr);
        return $this->success('登录成功，正在跳转...',url('Index/index'));
    }
}