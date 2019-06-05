<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class project {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

	public function lists(){
		$url = APP_URL.'api_project/lists';

		$postdata = array();
		if(isset($_GET['page'])){
			$currentPage = intval($_GET['page']);
			$currentPage = $currentPage > 0 ? $currentPage : 1;
			
		} else {
			$currentPage = 1;
		}

		$postdata['page'] = $currentPage;
		// 企业id
		$user_id = isset($_GET['enterprise_id']) ? intval($_GET['enterprise_id']) : '';
		if($user_id){
			$postdata['user_id'] = $user_id;
		}
		// 搜索标题
		$keyname = isset($_GET['keyname']) ? new_addslashes($_GET['keyname']) : '';
		if($keyname){
			$postdata['searchWord'] = $keyname;
		}

		$projects = $this->curl->post($url, $postdata);
		$projects = json_decode($projects, 1);

		$pages = pages($projects['data']['total'], $currentPage, 10);
		$projects = $projects['data']['list'];

		
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'project_list', $default_style);
	}

	public function show(){

		$url = APP_URL.'api_project/getOne';
		$postdata['project_id'] = intval($_GET['id']);

		$project = $this->curl->post($url, $postdata);
		$project = json_decode($project, 1);
		if($project['code'] == 400) showmessage($project['msg'], HTTP_REFERER);
		$project = $project['data'];

		extract($project);
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'project_show', $default_style);
	}
}