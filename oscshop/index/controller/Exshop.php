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
 
namespace osc\index\controller;
use osc\common\controller\HomeBase;
use think\Db;
use think\Request;
use osc\common\model\Goods;
class Exshop extends HomeBase
{
    public function index()
    {
		$this->assign('empty', '~~暂无数据');
		
		$this->assign('banner',Db::name('ads_items')->where('ad_id',6)->select());
		//轮播图实例化
		
		$cate=$this->getTree();
		foreach($cate as $v){
			if($v['id']=='62'){
				$class[]=$v;
			}
		}
		$this->assign('class',$class);
		//分类列表
		
		$this->assign('cat',osc_goods()->get_category_goods(37));
		//统计当前兑换劵数量
		
		$this->assign('list',$test=Db::name('goods')->where(['is_points_goods'=>1,'status'=>1])->order("goods_id desc")->limit(6)->select());
		//查询兑换所需积分>=1
		
		$search=Db::name('goods')->order('viewed desc')->limit(1)->select();
		$this->assign('search',$search);
		
		$this->assign('SEO',['title'=>config('SITE_TITLE'),'keywords'=>config('SITE_KEYWORDS'),'description'=>config('SITE_DESCRIPTION')]);
		
		
		return $this->fetch();
		
    }
	
	public function getTree($pid=0){
	//分类查询函数
		$list=Db::name('category')->where("pid=".$pid)->select();
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['child']=$this->getTree($v['id']);
				
			}
			
		}
		return $list;
	}
	
	
}
