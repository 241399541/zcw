<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 11:14
 */
namespace app\admin\controller;

use think\Controller;

class Article extends Controller{

    /**
     * 空操作
     *
     */
    public function _empty(){
        echo  '网址输入错误';
        exit;
    }

    public function index()
    {
        $data = db('article')
            ->alias('a')
            ->field('a.id,a.title,a.author,a.pic,a.keywords,a.state,a.click,a.time,c.catename')
            ->join('cate c', 'a.cateid=c.id')
            ->paginate(2);
        //echo db()->getLastSql();exit;
        $this->assign('data', $data);
        return $this->fetch("list");
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'title' => input('title'),
                'cateid' => input('cateid'),
                'author' => input('author'),
                'desc' => input('desc'),
                'title' => input('title'),
                'content' => input('content'),
                'time' => time(),
            ];
            //判断state状态
            if (input('state') == 'on') {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }
            //验证
            $validate = validate('Article');
            if (!$validate->scene('add')->check($data)) {
                return $this->error($validate->getError());
            }
            if ($_FILES['file']['tmp_name']) {
                //上传图片
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('file');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    //生成图片路径名
                    $filename = '/uploads/' . $info->getSaveName();
                    $filename = str_replace('\\', '/', $filename);
                    //把图片名称放在data数组里面
                    $data['pic'] = $filename;
                } else {
                    // 上传失败获取错误信息
                    return $this->error($file->getError());
                }
            }

            //处理关键字
            $keywords = input('keywords');
            $keywords = str_replace('，', ',', $keywords);
            $data['keywords'] = $keywords;

            //添加数据
            $res = db('article')->insert($data);
            if ($res) {
                return $this->success('添加成功', url('Article/index'));
            } else {
                return $this->error('添加失败');
            }
        }
        //查询所有栏目
        $cate = db('cate')->select();
        $this->assign('cate', $cate);
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $data = db('article')->find($id);
        $this->assign('data', $data);
        //查询所有栏目
        $cate = db('cate')->select();
        $this->assign('cate', $cate);
        return $this->fetch();
    }

    public function doEdit()
    {
        if (request()->isPost()) {
            $data = [
                'id' => input('id'),
                'title' => input('title'),
                'cateid' => input('cateid'),
                'author' => input('author'),
                'desc' => input('desc'),
                'title' => input('title'),
                'content' => input('content'),
                'time' => time(),
            ];
            //判断state状态
            if (input('state') == 'on') {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }
            //验证
            $validate = validate('Article');
            if (!$validate->scene('add')->check($data)) {
                return $this->error($validate->getError());
            }
            if ($_FILES['file']['tmp_name']) {
                //上传图片
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('file');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    //生成图片路径名
                    $filename = '/uploads/' . $info->getSaveName();
                    $filename = str_replace('\\', '/', $filename);
                    //把图片名称放在data数组里面
                    $data['pic'] = $filename;
                } else {
                    // 上传失败获取错误信息
                    return $this->error($file->getError());
                }
            }

            //处理关键字
            $keywords = input('keywords');
            $keywords = str_replace('，', ',', $keywords);
            $data['keywords'] = $keywords;
            //查出原来图片路径
            $image = db('article')->field('pic')->find($data['id']);
            $pic = $image['pic'];
            $res = db('article')->update($data);
            if ($res !== false) {
                //有新图片上传
                if (isset($data['pic']) && $data['pic']) {
                    //删除原来的图片
                    @unlink('.' . $pic);
                }
                return $this->success('修改成功', url('Article/index'));
            } else {
                return $this->error('修改失败');
            }
        }
        //查询所有栏目
        $cate = db('cate')->select();
        $this->assign('cate', $cate);
        return $this->fetch();
    }

    public function del()
    {
            $data = [
                'id' => input('id'),
            ];
            $image = db('article')->field('pic')->find($data['id']);
            $pic = $image['pic'];
            @unlink('.' . $pic);
            $res = db('article')->delete($data);
            if ($res) {

                return $this->success('删除成功', url('Article/index'));
            } else {
                return $this->error('删除失败');
            }
        }

}