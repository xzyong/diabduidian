<?php
namespace payment\weixin;
use osc\common\model\JournalAccount;
use payment\weixin\WxPayApi;
use payment\weixin\WxPayConfig;
use payment\weixin\WxPayException;
use payment\weixin\WxPayNotify;
use payment\weixin\WxPayOrderQuery;
use think\Db;
use think\Cache;
class WxPayNotifyCallBack extends WxPayNotify
{
	private $para;
	//查询订单
	public function Queryorder($transaction_id)
	{
	
		$input = new WxPayOrderQuery();
		
		$input->SetTransaction_id($transaction_id);
		
		$result = WxPayApi::orderQuery($input);		
		
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理方法，成功的时候返回true，失败返回false，处理商城订单
	//重写回调处理方法，成功的时候返回true，失败返回false，处理商城订单
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();

		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){

			$msg = "订单查询失败";
			return false;
		}

		if($data['result_code']=='SUCCESS'){


			$order = Db::name('order')->where('order_num_alias', $data['out_trade_no'])->find();

			if ($order && ($order['order_status_id'] == config('default_order_status_id'))) {

				osc_order()->update_order($order['order_id']);
				osc_order()->handle_point($order['order_id'], $order['uid']);

			}else{
				$dat=Cache::get('data');
				$orde = Db::name('journalAccount')->where('handle_id', $dat['trade_no'])->find();
				if($orde){

				}else{

					$journal_account = new JournalAccount([
							'amount' => $dat['total'],
							'user_id' => $dat['uid'],
							'create_time'=>time(),
							'type' => 1,
							'handle_id' => $dat['trade_no'],

					]);
					$journal_account->save();
					Db::name('member')->where('uid', $dat['uid'])->setInc('cash_points', $dat['number']);
				}

			}
			return true;
		}else{

			return false;
		}
	}
//自定义方法 检查微信端是否回调成功
//	public function is_success(){
//		return $this->para; //返回数据
//	}

//微信支付
	function logResult($word='')
	{
		$fp=fopen("upload.txt","a");
		flock($fp,LOCK_EX);
		fwrite($fp,'执行日期'.date("Y-m-d H:i:s",time())."\n".$word."\n");
		flock($fp,LOCK_UN);
		fclose($fp);
	}
}

