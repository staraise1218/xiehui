<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
class index {
	private $db;
	function __construct() {
		$this->db = pc_base::load_model('guoqing_model');
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

	function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}

	

	// 发送验证码
	public function sendMobileCode(){
		$postdata = new_addslashes($_POST);
		$url = APP_URL.'api_passport/sendMobileCode';

		$postdata['mobile'] = $postdata['phone'];
		$result = $this->curl->post($url, $postdata);

		die($result);
	}
}
?>