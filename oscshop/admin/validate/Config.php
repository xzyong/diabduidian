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
 */
namespace osc\admin\validate;
use think\Validate;
class Config extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2',
        'module'=>'require', 
        'value'=>	'require'
           
    ];

    protected $message = [
        'name.require'  =>  '配置名称必填',
        'name.min'  =>  '配置名称不能小于两个字',   
        'module.require'  =>  '模块必填',        
        'value.require'  =>  '配置值必填'
        
    ];

	
}
