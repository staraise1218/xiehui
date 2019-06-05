<?php


require_once ( './statics/plugin/payment/wxpay/WxPay.Api.php');
require_once ( './statics/plugin/payment/wxpay/WxPayConfig.php');
require_once ( './statics/plugin/payment/wxpay/MeetingPayNotify.php');


class wxpaywap {

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
		$input->SetTrade_type("MWEB");
		$scene_info = json_encode(array(
			'h5_info' => 'h5_info',
			array(
				'type' => 'Wap',
				'wap_url' => 'http://www.caapa.org',
				'wap_name' => '游乐园官网'
			)
		));
		$input->SetScene_info($scene_info);
		// $input->SetProduct_id("123456789");
		$result = $this->GetPayUrl($input);
		// p($result);
		/*Array
		(
		    [appid] => wx7b1b84d27f85d7c4
		    [mch_id] => 1529757561
		    [mweb_url] => https://wx.tenpay.com/cgi-bin/mmpayweb-bin/checkmweb?prepay_id=wx14160139296612606ed2e5be2040914492&package=4121558952
		    [nonce_str] => gvQk7qIQBgNuPoTi
		    [prepay_id] => wx14160139296612606ed2e5be2040914492
		    [result_code] => SUCCESS
		    [return_code] => SUCCESS
		    [return_msg] => OK
		    [sign] => 1ACEF50DD759481F7EA654B8D609E30F7F0EF43130E19C0DF5CF31E8E5F4AEFD
		    [trade_type] => MWEB
		)*/
		return $result["mweb_url"];
		
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
			$config = new WxPayConfig();
			$result = \WxPayApi::unifiedOrder($config, $input);
			return $result;
		
		return false;
	}
}