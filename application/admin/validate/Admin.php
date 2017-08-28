<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 14:00
 */

namespace app\admin\validate;
use think\Validate;

class Admin extends Validate{

    /**
     * @var array
     * 验证规则
     */

    protected $rule = [
        'username'  =>  'require|max:25|unique:admin',
        'password' =>  'require',
    ];

    /**
     * @var array
     * 验证提示文字
     */
    protected $message  =   [
        'username.require' => '用户名不能为空',
        'username.max'     => '用户名最多不能超过25个字符',
        'username.unique'     => '用户名不能重复',
        'password.require'     => '密码不能为空',
    ];

    /**
     * @var array
     * 验证提示文字
     */

    protected $scene = [
        'add' => ['username','password'],
        'edit' => ['username'],
    ];
}
