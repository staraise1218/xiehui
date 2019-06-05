<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class enterprise {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);

  		// 企业
		$this->db_enterprise = pc_base::load_model('front_enterprise_model');
		$this->db_image = pc_base::load_model('image_image_model');
	}

	public function lists(){
		if(isset($_GET['page'])){
			$currentPage = intval($_GET['page']);
			$currentPage = $currentPage > 0 ? $currentPage : 1;
			
		} else {
			$currentPage = 1;
		}

		$where = "check_status = '1' and enabled='1'";
		
		$keyname = isset($_GET['keyname']) ? new_addslashes($_GET['keyname']) : '';
		if($keyname){
			$where .=  " and enterprise_name like '%{$keyname}%'";
		}

		$count = $this->db_enterprise->count($where);
		$enterprises = $this->db_enterprise->listinfo($where, 'user_id desc', $currentPage, 10);
		if(is_array($enterprises) && !empty($enterprises)){
			foreach ($enterprises as $k => &$v) {
				$image = $this->db_image->get_one(array('image_id'=>$v['image_logo_id']), 'url');
				$v['image_url'] = APP_BASE_URL.'/'.$image['url'];
				unset($enterprises[$k]['image_logo_id']);
			}
		}

		$pages = pages($count, $currentPage, 10);
		
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'enterprise_list', $default_style);
	}

	public function show(){

		$user_id = intval($_GET['id']);

		$where = array(
			'user_id' => $user_id,
			'check_status' => '1',
			'enabled' => '1'
		);
		$enterprise = $this->db_enterprise->get_one($where);
		if(empty($enterprise)) showmessage('公司不存在', HTTP_REFERER);

		extract($enterprise);
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'default';
		include template('app', 'enterprise_show', $default_style);
	}
}