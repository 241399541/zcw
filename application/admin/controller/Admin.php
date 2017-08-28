<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 11:14
 */
namespace app\admin\controller;

use think\Controller;
use think\validate;
class Admin extends Controller{
    /**
     * 空操作
     *
     */
    public function _empty(){
        echo  '网址输入错误';
        exit;
    }

    public function index(){
        $data = db('admin')->paginate(2);
        $this->assign('data',$data);
        return $this->fetch("list");
    }

    public function add(){
        if(request()->isPost()){
            $data = [
                'username' => input('username') ,
                'password' => md5(input('password')) ,
            ];
            //判断state状态
            if (input('state') == 'on') {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }

            //验证
            $validate = validate('Admin');
            if(!$validate->scene('add')->check($data)){
                return $this->error($validate->getError());
            }

            //添加数据
            $res = db('admin')->insert($data);

            if($res){
                return $this->success('添加成功',url('Admin/index'));
            }else{
                return $this->error('添加失败');
            }

        }
        return $this->fetch();
    }

    public function edit(){
        $id = input('id');
        $data = db('admin')->find($id);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function doEdit(){
        $username=input('username');
        $password=input('password');
        $id =input('id');
        $data = [];
        $data['username'] = $username;
        $data['id'] = $id;
        if($password != ''){
            $data['password'] = md5($password);

        }
        //判断state状态
        if (input('state') == 'on') {
            $data['state'] = 1;
        } else {
            $data['state'] = 0;
        }
        //验证
        $validate = validate('Admin');
        if(!$validate->scene('edit')->check($data)){
            return $this->error($validate->getError());
        }

        $res = db('admin')->update($data);
        if($res !== false){
            return $this->success('修改成功',url('Admin/index'));
        }else{
            return $this->error('修改失败');
        }
    }

    public function del(){
        $id = input('id');
        if($id == '1'){
            return $this->error('超级管理员不删除');
        }
        $res = db('admin')->delete($id);
        if($res){
            return $this->success('删除成功',url('Admin/index'));
        }else{
            return $this->error('删除失败');
        }
    }
}