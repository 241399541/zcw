<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 14:00
 */

namespace app\admin\validate;
use think\Validate;

class Cate extends Validate{

    /**
     * @var array
     * 验证规则
     */

    protected $rule = [
        'catename'  =>  'require|max:25|unique:cate',
    ];

    /**
     * @var array
     * 验证提示文字
     */
    protected $message  =   [
        'catename.require' => '栏目名不能为空',
        'catename.max'     => '栏目名最多不能超过25个字符',
        'catename.unique'     => '栏目名不能重复',
       
    ];

    /**
     * @var array
     * 验证提示文字
     */

    protected $scene = [
        'add' => ['catename'],
        'edit' => ['catename'],
    ];
}
