<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

	public function index(){
		// 项目
		$project_url = APP_URL.'api_project/lists';
		$projects = $this->curl->post($project_url);
		$projects = json_decode($projects, 1);
		$projects = $projects['data']['list'];

		// 产品
		$product_url = APP_URL.'api_product/lists';
		$products = $this->curl->post($product_url);		
		$products = json_decode($products, 1);
		$products = $products['data']['list'];
		// 招聘
		$recruit_url = APP_URL.'api_category/getAdvertises';
		$recruits = $this->curl->post($recruit_url);		
		$recruits = json_decode($recruits, 1);
		$recruits = $recruits['data']['advertises'];

		// 企业
		$db_enterprise = pc_base::load_model('front_enterprise_model');
		$db_image = pc_base::load_model('image_image_model');
		$where = array(
			'check_status' => '1',
			'enabled' => '1'
		);
		$enterprises = $db_enterprise->select($where, 'user_id, enterprise_name, image_logo_id, biref', 3, 'user_id desc');
		if(is_array($enterprises) && !empty($enterprises)){
			foreach ($enterprises as $k => &$v) {
				$image = $db_image->get_one(array('image_id'=>$v['image_logo_id']), 'url');
				$v['image_url'] = APP_BASE_URL.'/'.$image['url'];
				unset($enterprises[$k]['image_logo_id']);
			}
		}

		// 论坛
		$forum_url = APP_URL.'api_community/getListAll';
		$forums = $this->curl->post($forum_url, array('type'=>'2'));		
		$forums = json_decode($forums, 1);
		$forums = $forums['data']['list'];


		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'index', $default_style);
	}

	public function show(){

		$url = APP_URL.'api_project/getOne';
		$postdata['project_id'] = intval($_GET['project_id']);

		$is_ok = $this->http->post($url, $postdata);
		if(!$is_ok) showmessage('远程服务器错误');

		$project = $this->http->get_data();
		$project = json_decode($project, 1);
		if($project['code'] == 400) showmessage($project['msg'], 'goback');
		$SEO = seo(SITEID);
		$project = $project['data'];
	}
}