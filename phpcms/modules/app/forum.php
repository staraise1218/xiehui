<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class forum {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

	// 文章列表
	public function artlists($type='2'){
		$url = APP_URL.'api_community/getListAll';


		$postdata = array('type'=>$type);
		if(isset($_GET['page'])){
			$currentPage = intval($_GET['page']);
			$currentPage = $currentPage > 0 ? $currentPage : 1;
			
		} else {
			$currentPage = 1;
		}

		$postdata['page'] = $currentPage;

		$forums = $this->curl->post($url, $postdata);
		$forums = json_decode($forums, 1);

		$pages = pages($forums['data']['total'], $currentPage, 10);
		$forums = $forums['data']['list'];

		// echo '<pre>';print_r($forums);die();
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		if($type == '2'){
			include template('app', 'article_list', $default_style);
		} elseif($type == '1') {
			include template('app', 'ask_list', $default_style);
		}
	}

	public function asklists(){
		return $this->artlists('1');
	}

	public function show(){

		$url = APP_URL.'api_community/getInterlocution';
		$postdata['inter_id'] = intval($_GET['id']);
		$type = isset($_GET['type']) ? $_GET['type'] : 'art';

		$commentPage = 1;
		if(isset($_GET['page'])){
			$commentPage = intval($_GET['page']);
			$commentPage = $commentPage > 0 ? $commentPage : 1;
		}
		$postdata['page'] = $commentPage;

		$forum = $this->curl->post($url, $postdata);
		$forum = json_decode($forum, 1);
		if($forum['code'] == 400) showmessage($forum['msg'], HTTP_REFERER);
		$forum = $forum['data'];

		$pages = pages($commentPage, $commentPage, 10);

		extract($forum);
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		if($type == 'ask'){
			include template('app', 'forum_showask', $default_style);
		} elseif($type == 'art') {
			include template('app', 'forum_showart', $default_style);
		}
	}
}