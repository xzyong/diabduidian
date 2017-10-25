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
use \wechat\OscshopWechat;
use think\Request;
use osc\common\model\Goods;
class Index extends HomeBase
{



    public function index()
    {





        if(request()->isGet()){
//            dump(input('param.states'));
            $this->assign('states',input('param.states'));
        }
		
		$category=Db::name('category')->where('pid',0)->where('name','商品充值')->field('id')->select();
		
		$this->assign('empty', '~~暂无数据');
		
		$this->assign('category',$category);
		
        $this->assign('list1',$this->sel('0',2,'sort_order'));
		//限时特价查询语句
		
        $this->assign('list4',$this->sell(4));
        $this->assign('list2',Db::name('goods')->where(['is_points_goods'=>1,'status'=>1])->order("goods_id desc")->limit(8)->select());
        $this->assign('list3',Db::name('goods')->where(['is_points_goods'=>1,'status'=>1])->order("viewed desc")->limit(4)->select());
        $this->assign('banner',Db::name('ads_items')->where('ad_id',1)->select());
		#轮播查询ad_id为1的图片
		$this->assign('SEO',['title'=>config('SITE_TITLE'),'keywords'=>config('SITE_KEYWORDS'),'description'=>config('SITE_DESCRIPTION')]);
		
		return $this->fetch();
   
    }

    public function article(){
        if(request()->isGet()){
            $this->assign('list',Db::view('message','*')->view('admin','user_name','admin.admin_id=message.author')->where('message.id',input('param.id'))->find());
            $this->assign('SEO',['title'=>'文章-'.config('SITE_URL').config('SITE_TITLE')]);
            return $this->fetch();
        }else{
            $this->error('参数错误');
        }

    }


    public function sel($is_points_goods,$num,$con){
	//					是否为兑换商品	查询数	按...排序
       $list= Db::name('goods')->where('end_time','>',date('Y-m-d,H-i-s'))->where(['is_points_goods'=>$is_points_goods,'status'=>1])->order("$con asc")->limit($num)->select();
	   //查询'goods'数据表信息，条件：秒杀时间大于当前时间、不是积分兑换商品、为上架商品
	   
       if ($is_points_goods==0) {
          foreach ($list as $key => $v) {
           $list[$key]['end_time']=strtotime($v['end_time'])*1000;
          }
       }
       
       return $list;
    }


}
