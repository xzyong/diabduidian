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
 * 扫码支付
 */
namespace osc\payment\controller;
use osc\common\controller\Base;
use payment\weixin\WxPayApi;
use payment\weixin\WxPayConfig;
use payment\weixin\WxPayUnifiedOrder;
use osc\common\model\JournalAccount;
use payment\weixin\WxPayNotifyCallBack;
use think\Cache;
use think\Db;

class Weixin extends Base{
	
	function process(){
		return ['type'=>'wx_pay','url'=>url('/wxpay')];
	}
	
	public function re_pay($order_id){
		return ['type'=>'wx_pay','pay_url'=>url('payment/weixin/re_pay_code',array('order_id'=>$order_id))];
	}
	public function charge_pay($data){
		return ['type'=>'wx_pay','pay_url'=>url('payment/weixin/charege_code',$data)];
	}
//充值二维码
	function charege_code(){

		$data=input('param.');

		$config=payment_config('weixin');
		$data['trade_no']=build_order_no().member('uid');
		$data['uid']=member('uid');
		Cache::set('data',$data,7200);
		$cfg = array(
				'APPID'     => $config['appid'],
				'MCHID'     => $config['weixin_partner'],
				'KEY'       => $config['partnerkey'],
				'APPSECRET' => $config['appsecret'],
				'NOTIFY_URL' =>request()->domain().url('payment/weixin/weixin_notify'),
		);
		WxPayConfig::setConfig($cfg);
		//②、统一下单


		$input = new WxPayUnifiedOrder();
		$input->SetBody('点对点商城充值兑换券微信支付');
		$input->SetAttach('附加数据');
		$input->SetOut_trade_no($data['trade_no']);

	        $input->SetTotal_fee((float)$data['total']*100);
//		$input->SetTotal_fee(0.01*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetTrade_type('NATIVE');

		$input->SetProduct_id(time());

		$wxapi=new WxPayApi();
//
		$url= $wxapi->unifiedOrder($input);

		$this->assign('url',$url['code_url']);

		$this->assign('trade_no',$data['trade_no']);



		return $this->fetch('recode');
	}



	//会员中心去支付
	public function re_pay_code(){
		
		$order_id=(int)input('order_id');
		$data['trade_no']=build_order_no().member('uid');
		$order=Db::name('order')->where('order_id',$order_id)->find();

		if($order&&($order['order_status_id']!=config('paid_order_status_id'))){
			$config=payment_config('weixin');
			$cfg = array(
					'APPID'     => $config['appid'],
					'MCHID'     => $config['weixin_partner'],
					'KEY'       => $config['partnerkey'],
					'APPSECRET' => $config['appsecret'],
					'NOTIFY_URL' =>request()->domain().url('payment/weixin/weixin_notify'),
			);
			WxPayConfig::setConfig($cfg);
			//②、统一下单
			$trade_no=build_order_no().member('uid');

			Db::name('order')->where('order_id',$order['order_id'])->update(array('order_num_alias'=>$trade_no,'payment_code'=>'weixin'));

			$input = new WxPayUnifiedOrder();
			$input->SetBody('点对点商城订单微信支付');
			$input->SetAttach('附加数据');
			$input->SetOut_trade_no($trade_no);

	        $input->SetTotal_fee((float)$order['total']*100);
//			$input->SetTotal_fee(0.01*100);
			$input->SetTime_start(date("YmdHis"));
			$input->SetTime_expire(date("YmdHis", time() + 600));
			$input->SetTrade_type('NATIVE');

			$input->SetProduct_id(time());

			$wxapi=new WxPayApi();

			$url= $wxapi->unifiedOrder($input);
			$this->assign('url',$url['code_url']);
			
			$this->assign('order_id',$order_id);
			$this->assign('trade_no',$trade_no);
			return $this->fetch('recode'); 
		}
	}
	public function get_order_status(){
		
		$data=input('post.');
		
		$order=Db::name('order')->where('order_num_alias',$data['out_trade_no'])->find();	
		
		if($order['order_status_id']==config('paid_order_status_id')){
			return url('index/pay_success/pay_success',['order_id'=>$order['order_id']]);
		}else{
			if($ord=Db::name('journalAccount')->where('handle_id',$data['out_trade_no'])->find()){
				return 2;
			}else{
				return 3;
			}

		}
	}

	public function weixin_notify(){

		$config=payment_config('weixin');

		$notify_url=request()->domain().url('payment/weixin/weixin_notify');

		$cfg = array(
				'APPID'     => $config['appid'],
				'MCHID'     => $config['weixin_partner'],
				'KEY'       => $config['partnerkey'],
				'APPSECRET' => $config['appsecret'],
				'NOTIFY_URL' => $notify_url,
		);
		WxPayConfig::setConfig($cfg);

		$call_back=new WxPayNotifyCallBack();

		$call_back->Handle(false);

	}


}
