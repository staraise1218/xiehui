<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class register {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

	public function index(){

		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'default';
		include template('app', 'register_index', $default_style);
	}

	// 发送验证码
	public function sendMobileCode(){
		$postdata = new_addslashes($_POST);
		$url = APP_URL.'api_passport/sendMobileCode';

		$postdata['mobile'] = $postdata['phone'];
		$result = $this->curl->post($url, $postdata);

		die($result);
	}

	// 发送邮箱验证码
	public function sendEmailCode(){
		$postdata = $_POST;
		$url = APP_URL.'api_passport/sendEmailCode';
		$result = $this->curl->post($url, $postdata);

		die($result);
	}

	// 注册个人账号
	public function registerUser(){
		$url = APP_URL.'api_passport/registerUser';

		$postdata = $_POST;
		
		$result = $this->curl->post($url, $postdata);
		die($result);
	}


	public function registerEnterpriseStep1()
	{
		$postdata = $_POST;
		// 验证企业注册第一步信息
		$url = APP_URL.'api_passport/checkEnterprise';
		$result = $this->curl->post($url, $postdata);

		$re = json_decode($result, true);
		if($re['code'] == '200'){
			// echo '<pre>'; print_r($postdata);die();
			setcookie('email', $postdata['email']);
			setcookie('code', $postdata['code']);
			setcookie('password', $postdata['password']);
			setcookie('password_re', $postdata['password_re']);
		}
		die($result);
	}

	// 注册企业账号
	public function registerEnterprise(){
		if($_POST['dosubmit']){
			$url = APP_URL.'api_passport/registerEnterprise';

			$postdata = $_FILES;

			echo '<pre>';print_r($postdata);die();
			$result = $this->curl->post($url, $postdata);
			die($result);
			
		} else {
			$email = $_COOKIE['email'];
			$code = $_COOKIE['code'];
			$password = $_COOKIE['password'];
			$password_re = $_COOKIE['password_re'];

			$SEO = seo(SITEID);
			include template('app', 'register_enterprise');
		}
	}
}