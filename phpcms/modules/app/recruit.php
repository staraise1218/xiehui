<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class recruit {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

	public function lists(){
		$url = APP_URL.'api_category/getAdvertises';

		$postdata = array();
		if(isset($_GET['page'])){
			$currentPage = intval($_GET['page']);
			$currentPage = $currentPage > 0 ? $currentPage : 1;
		} else {
			$currentPage = 1;
		}

		$postdata['page'] = $currentPage;

		$keyname = isset($_GET['keyname']) ? new_addslashes($_GET['keyname']) : '';
		if($keyname){
			$postdata['searchWord'] = $keyname;
		}
		// 企业id
		$user_id = isset($_GET['enterprise_id']) ? intval($_GET['enterprise_id']) : '';
		if($user_id){
			$postdata['user_id'] = $user_id;
		}

		$recruits = $this->curl->post($url, $postdata);
		$recruits = json_decode($recruits, 1);

		$pages = pages($recruits['data']['total'], $currentPage, 10);
		$recruits = $recruits['data']['advertises'];

		
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'default';
		include template('app', 'recruit_list', $default_style);
	}

	public function show(){

		$url = APP_URL.'api_category/advertiseDetail';
		$postdata['advertise_id'] = intval($_GET['id']);

		$recruit = $this->curl->post($url, $postdata);
		$recruit = json_decode($recruit, 1);

		if($recruit['code'] == 400) showmessage($recruit['msg'], HTTP_REFERER);
		$recruit = $recruit['data'];

		extract($recruit);
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'default';
		include template('app', 'recruit_show', $default_style);
	}
}