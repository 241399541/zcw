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
    class Cate extends Controller{

        /**
         * 空操作
         *
         */
        public function _empty(){
            echo  '网址输入错误';
            exit;
        }

    public function index(){
        $data = db('cate')->paginate(2);
        $this->assign('data',$data);
        return $this->fetch("list");
    }

    public function add(){
        if(request()->isPost()){
            $data = [
                'catename' => input('catename') ,

            ];

            //验证
            $validate = validate('Cate');
            if(!$validate->scene('add')->check($data)){
                return $this->error($validate->getError());
            }

            //添加数据
            $res = db('cate')->insert($data);
            if($res){
                return $this->success('添加成功',url('Cate/index'));
            }else{
                return $this->error('添加失败');
            }
        }
        return $this->fetch();
    }

    public function edit(){
        $id = input('id');
        $data = db('cate')->find($id);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function doEdit(){
        $catename=input('catename');
        $id =input('id');
        $data = [];
        $data['catename'] = $catename;
        $data['id'] = $id;
        //验证
        $validate = validate('Cate');
        if(!$validate->scene('edit')->check($data)){
            return $this->error($validate->getError());
        }

        $res = db('cate')->update($data);
        if($res !== false){
            return $this->success('修改成功',url('Cate/index'));
        }else{
            return $this->error('修改失败');
        }
    }

    public function del(){
        $id = input('id');
        $res = db('cate')->delete($id);
        if($res){
            return $this->success('删除成功',url('Cate/index'));
        }else{
            return $this->error('删除失败');
        }
    }
}