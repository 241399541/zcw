<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 10:16
 */
namespace app\admin\controller;

use think\Controller;

class Index extends Controller{
    public function index(){
        return $this->fetch();
    }

    /**
     * 空操作
     *
     */
    public function _empty(){
        echo  '网址输入错误';
        exit;
    }

    /**
     * 退出登录
     *
     */
    public function logout(){
        session('admin',null);
        return $this->redirect('Login/index');
    }
}