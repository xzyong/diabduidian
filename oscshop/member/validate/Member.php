<?php
/**
 * Waynes电子商务系统
 *
 * ==========================================================================
 * @link      http://www.waynes-tech.com
 * @copyright Copyright (c) 2015-2016 深圳市韦恩斯科技有限公司

 * ==========================================================================
 *
 * @author    深圳韦恩斯科技有限公司
 *
 * 后台新增会员
 */
 
namespace osc\member\validate;
use think\Validate;
class Member extends Validate
{
    protected $rule = [
        
        'password'=>'require|min:6',

        'telephone'  =>  'unique:member',
    ];

    protected $message = [
		
        
		'password.require'  =>  '密码必填',
		'password.min'  =>  '密码不能小于6位',  	

		'telephone.unique'  =>  '手机号码已经存在',
    ];
	/*'nickname.require'  =>  '昵称必填',
        'nickname.min'  =>  '昵称不能小于两个字',
		
        'nickname.unique'  =>  '昵称已经存在',
		'nickname'  =>  'require|min:2|unique:member',
        */
	protected $scene = [
        'edit'  =>  ['password','email','telephone'],
    ];
	
}
?>