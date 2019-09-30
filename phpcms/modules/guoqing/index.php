<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
class index {
	private $db;
	private $curl;
	function __construct() {
		$this->db = pc_base::load_model('guoqing_model');
		$this->curl = pc_base::load_sys_class('curl');
		/*$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');*/
	}

	//首页
	public function init() {
		// 获取access_token
		$output = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx7b1b84d27f85d7c4&secret=5bc386846ad2feb31f973dcb65d4b203");
		$res = json_decode($output, true);
		$accessToken = $res["access_token"];
		// 获取jsapi_ticket
		$output = file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$accessToken}&type=jsapi");
		$getTicket= json_decode($output, ture);
		$ticket = $getTicket['ticket'];

		
		$nonceStr = $this->createNonceStr();
		$timestamp = time();
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$string = "jsapi_ticket=".$ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
		$signature = sha1($string);
		
		// 获取所有的经纬度坐标
		$list = $this->db->select("longitude != '' and latitude != ''", 'longitude, latitude');
		$list = json_encode($list);

		include template('guoqing','index', 'mobile');
	}

	public function submit(){
		$data = $_POST;

		// 检测验证码是否正确
		/*if( false == $this->checkMobileCode($data['mobile'], $data['code'], 1, $error)){
			die(json_encode(array('code'=>400, 'msg'=>$error)));
		}*/

		$this->db->insert($data);

		$count = $this->db->count("longitude != '' and latitude != ''");
		die(json_encode(array('code'=>200, 'count'=>$count)));
	}

	function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}



	// 发送验证码
	
	// scene 1 活动报名 
	public function sendMobileCode(){
		$mobile = $_POST['mobile'];
        $scene = $_POST['scene'];
die(json_encode(array('code'=>400, 'msg'=>'发送成功')));
         // 检测发送次数
        $day_time_start = strtotime(date('Y-m-d'));
        $day_time_end = $day_time_start + 3600*24;

        $sms_log_model = pc_base::load_model('sms_log_model');
        $count = $sms_log_model->count("mobile=$mobile and add_time > $day_time_start and add_time < $day_time_end");

        if($count >= 10){
            die(json_encode(array('code'=>400, 'msg'=>'您的次数已超限')));
        }

        $code = rand(100000, 999999);
        $data = array(
            'mobile' => $mobile,
            'code' => $code,
            'scene' => $scene,
            'add_time' => time(),
        );

        $smsLogid = $sms_log_model->insert($data, true);

        // 执行短信网关发送 
        $rongliansms = pc_base::load_sys_class('rongliansms');
        $result = $rongliansms->sendTemplateSMS($mobile, array($code), 207012);

        if(empty($result)){
			die(json_encode(array('code'=>400, 'msg'=>'发送失败')));
		}elseif($result->statusReturn == false){
			if($result->statusCode == '160040'){
				die(json_encode(array('code'=>400, 'msg'=>'该电话号码今日获取验证码已达上限')));
			}else{
				die(json_encode(array('code'=>400, 'msg'=>'发送失败')));
			}
		}
		else{
			$sms_log_model = pc_base::load_model('sms_log_model');
			$sms_log_model->update(array('status'=>'1'), array('id'=>$smsLogid));
			die(json_encode(array('code'=>400, 'msg'=>'发送成功')));
			
		}
	}

	// 检测验证码
	public function checkMobileCode($mobile, $code, $scene, &$error){
		$sms_log_model = pc_base::load_model('sms_log_model');
		$smsLog = $sms_log_model->get_one("mobile=$mobile and scene=$scene", 'code, add_time', 'id desc');

        if(!$smsLog){
            $error = '手机验证码错误';
            return false;
        }

        if($smsLog['code'] != $code){
            $error = '手机验证码错误';
            return false;
        }

        if(time() > ($smsLog['add_time'] + 300)){
            $error = '验证码已失效';
            return false;
        }
        return true;
	}
}
?>