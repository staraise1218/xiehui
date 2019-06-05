<?php


require_once ( './statics/plugin/payment/wxpay/WxPay.Api.php');
require_once ( './statics/plugin/payment/wxpay/WxPayConfig.php');
require_once ( './statics/plugin/payment/wxpay/MeetingPayNotify.php');


class wxpay {

	public $notify_url = '';
	public function pagepay($order_sn, $subject, $total_amount){
		//模式二
		/**
		 * 流程：
		 * 1、调用统一下单，取得code_url，生成二维码
		 * 2、用户扫描二维码，进行支付
		 * 3、支付完成之后，微信服务器会通知支付成功
		 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
		 */
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($subject);
		$input->SetAttach("test");
		$input->SetOut_trade_no($order_sn.date("His"));
		$input->SetTotal_fee($total_amount*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url($this->notify_url);
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id("123456789");

		$result = $this->GetPayUrl($input);
		return $result["code_url"];
		
	}

	public function BuyReportNotify(){
		$config = new WxPayConfig();
        $notify = new BuyReportNotify();
        
        return $notify->Handle($config, false);
	}

	// 会议支付回调
	public function meetingPayNotify(){
		$config = new WxPayConfig();
        $notify = new MeetingPayNotify();

        return $notify->Handle($config, false);
	}

	/**
	 * 
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	private function GetPayUrl($input)
	{
		if($input->GetTrade_type() == "NATIVE")
		{
			$config = new WxPayConfig();
			$result = \WxPayApi::unifiedOrder($config, $input);
			return $result;
		}
		return false;
	}
}