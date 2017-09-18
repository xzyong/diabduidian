<?php
/**
 *
 * @author    深圳韦恩斯科技有限公司
 *会员中心
 */
namespace osc\common\controller;
use osc\common\model\ShopCart;
use think\Db;
use osc\member\service\User;
class HomeBase extends Base{	
	
	protected function _initialize() {
		parent::_initialize();		
		

		if(member('uid')){

		}
//		dump(urlencode('http://wsjietubao.com/app/login/weixin'));die;
		$this->assign('appid',config('appid'));
		$this->assign('url',urlencode(request()->url(true).'member/login/wei_login'));
		$this->assign('states',0);
		$this->assign('message',Db::name('message')->select());
		$this->assign('cart',Db::name('cart')->where('uid',member('uid'))->count());
		$this->assign('logo',Db::name('ads_items')->where('ad_id',3)->find());
		$this->assign('code',Db::name('ads_items')->where('ad_id',5)->find());
		$this->assign('mess_cate',Db::name('message_category')->select());
		$this->assign('copy',Db::name('config')->where('id',112)->find());

		$pid =Db::name('member')->where('uid',member('pid'))->find();
		if($pid){
			$this->assign('pid',$pid['nickname']);
		}else{
			$this->assign('pid','您没有推荐人');
		}
		$this->assign('number',['1'=>$this->num(1),'3'=>$this->num(3),'4'=>$this->num(4)]);
		$this->assign('member',User::get_logined_user());
		
	}
	//统计订单数量
	public function num($id){
		$count = Db::name('order')->where('order_status_id',$id)->where('uid',member('uid'))->count();
		return $count;
	}
	public function sell($num){
		$list= Db::name('goods')->where(['is_points_goods'=>0,'status'=>1])->order("viewed desc")->limit($num)->select();
		// dump($list);die;
		foreach ($list as $key => $v) {
			if ($v['end_time']!==NULL) {

				if ( strtotime($v['end_time'])<time() ) {
					$list[$key]['end_time']=1;

				}else{
					$list[$key]['end_time']=strtotime($v['end_time'])*1000;

				}
			}
		}
		// var_dump($list[3]);die;
		return $list;
	}

}
