<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

require_once ('./statics/plugin/phpqrcode/phpqrcode.php');
class pay {
    private $db;
    private $Alipay;
    private $Wxpay;

	function __construct() {
        $this->db = pc_base::load_model('activity_apply_model');
        $this->Alipay = pc_base::load_sys_class('alipay');
        $this->Wxpay = pc_base::load_sys_class('wxpay');

		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

    public function topay(){
    	$order_sn = input('param.order_sn');
    	$paymentMethod = input('param.payname');

        // seo
        $SEO = seo(SITEID);

    	/******** 检测订单状态 **************/
    	$order = $this->db->get_one("order_sn='{$order_sn}'", 'pay_status, price');
    	if(empty($order)) showmessage('订单不存在');
    	if($order['pay_status'] == 1) showmessage('订单已支付');
    	if(!in_array($paymentMethod, array('alipay', 'wxpay'))) showmessage('支付方式异常');

		$subject = '会议报名费';
    	if($paymentMethod == 'alipay'){
            $total_amount = $order['price'];
            $this->Alipay->returnUrl = 'http://www.caapa.org/index.php?m=activity&c=pay&a=resultPage_alipay';
            $this->Alipay->notifyUrl = 'http://www.caapa.org/index.php?m=activity&c=pay&a=alipayCallback';

    		$this->Alipay->pagepay($order_sn, $subject, $total_amount);
    	}

        if($paymentMethod == 'wxpay'){
            $total_amount = $order['price'];
            $this->Wxpay->notify_url = 'http://www.caapa.org/meetingPayCallback.php';
            $code_url = $this->Wxpay->pagepay($order_sn, $subject, $total_amount);

            include template('activity','wxpay_pagepay','default');
            // $this->assign('code_url', $code_url);
            // $this->assign('order_sn', $order_sn);
            // $this->assign('total_amount', $total_amount);
            // return $this->fetch('wxpay_pagepay');
        }
    }

    public function qrcode(){
        $url = urldecode(input('param.url'));

        if(substr($url, 0, 6) == "weixin"){
            \QRcode::png($url);
        }
    }
    // 支付宝支付回调
    public function alipayCallback(){

        $checkResult = $this->Alipay->checkSign();
        file_put_contents('caches/error_log.php',"\r\n".var_export($_POST, true), FILE_APPEND);
        if( FALSE == $checkResult) return false;

        // 处理业务流程
        if($_POST['trade_status'] == 'TRADE_SUCCESS'){
            $order_sn =$_POST['out_trade_no'];
            $updatedata = array(
                'pay_status' => 1,
                'pay_time' => time(),
                'pay_method' => '1',
            );
            // 更新订单表
            $this->db->update($updatedata, array('order_sn'=>$order_sn));
        }

        echo 'success';
    }

    // 微信支付回调
    public function wxpayCallback(){
// file_put_contents('caches/error_log.php',"\r\n".var_export($_POST, true), FILE_APPEND);
        // $this->Wxpay->meetingPayNotify();
    }


    // 微信支付二维码页面判断订单是否支付
    public function getPayStatus(){
        $order_sn = input('order_sn');

        $order = $this->db->get_one("order_sn='{$order_sn}'", 'pay_status');
        if(empty($order)) die(array('code'=>400, 'msg'=>'订单无效'));

        $status = $order['pay_status'];
        die(json_encode(array('code'=>200, 'status'=> $status)));
    }

    public function resultPage(){
        $paystatus = input('paystatus');

        //SEO
        $SEO = seo(SITEID);

        include template('activity','result_page','default');
    }

    public function resultPage_alipay(){
        $order_sn = input('out_trade_no');
        $info = $this->db->get_one(array('order_sn'=>$order_sn), 'pay_status');
        $paystatus = $info['pay_status'];

        //SEO
        $SEO = seo(SITEID);


        include template('activity','result_page','default');
    }

}