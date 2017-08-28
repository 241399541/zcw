<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 20:54
 */
namespace app\index\controller;

use think\Controller;

class Lis extends Controller{

    /**
     * 空操作
     *
     */
    public function _empty(){
        echo  '网址输入错误';
        exit;
    }

    public function index(){
        $id = input('id');
        //查询栏目名称
        $cate = db('cate')->field('catename')->find($id);
        if(isset($id) && $id){
            //查询所有文章
            $articleData = db('article')->where(['cateid'=>$id])->field('id,title,desc,time,pic,keywords')->paginate(1);

        }

        $keywords = input('keywords');
        //dump($keywords);exit;
       if(isset($keywords) && $keywords){
            $map['keywords'] = ['like','%'.$keywords.'%'];
            $articleData = db('article')->where($map)->field('id,title,desc,time,pic,keywords')->paginate(1,false,[ 'query'=>['keywords'=>$keywords]]);
            //echo db()->getLastSql();exit;
        }
        $this->assign('keywords',$keywords);
        $this->assign('articleData',$articleData);
        $this->assign('cate',$cate);

        return $this->fetch("list");
   }
}