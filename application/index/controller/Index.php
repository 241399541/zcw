<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 16:16
 */
namespace app\index\controller;

use think\Controller;

class Index extends Controller{

    /**
     * 空操作
     *
     */
    public function _empty(){
        echo  '网址输入错误';
        exit;
    }

    public function index(){
        //查询所有文章
        $articleData = db('article')->field('id,title,desc,time,pic,keywords')->paginate(8);
        $this->assign('articleData',$articleData);
        //加载模板
        return $this->fetch();
    }
}
