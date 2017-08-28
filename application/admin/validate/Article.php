<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 14:00
 */

namespace app\admin\validate;
use think\Validate;

class Article extends Validate{

    /**
     * @var array
     * 验证规则
     */

    protected $rule = [
        'title'  =>  'require|max:25|unique:article',
        'cateid' =>  'require',
        'author' =>  'require',
    ];

    /**
     * @var array
     * 验证提示文字
     */
    protected $message  =   [
        'title.require' => '名称不能为空',
        'title.max'     => '名称最多不能超过25个字符',
        'title.unique'     => '名称不能重复',
        'cateid.require'     => '栏目名称不能为空',
        'author.require'     => '作者名称不能为空',
    ];

    /**
     * @var array
     * 验证提示文字
     */

    protected $scene = [
        'add' => ['title','cateid','author'],
        'edit' => ['title','cateid','author'],
    ];
}
