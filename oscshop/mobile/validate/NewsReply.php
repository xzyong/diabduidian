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
namespace osc\mobile\validate;
use think\Validate;
class NewsReply extends Validate
{
    protected $rule = [
        'keyword'  =>  'require|unique:wechat_rule',
        'content'=>'require',       
        'title'=> 'require',
    ];

    protected $message = [
        'keyword.require'  =>  '关键字必填',  
        'title.require'  =>  '标题必填',  
        'keyword.unique'  =>  '关键字已经存在',             
		'content.require'  =>  '图文内容必填',
    ];

	protected $scene = [
        'edit'  =>  ['keyword'=>'require','content','title'],
    ];
}
?>