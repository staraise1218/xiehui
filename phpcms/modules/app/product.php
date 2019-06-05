<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class product {

	private $curl;

	function __construct() {
		$this->curl = pc_base::load_sys_class('curl');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}

	public function lists(){
		$url = APP_URL.'api_product/lists';

		$postdata = array();
		if(isset($_GET['page'])){
			$currentPage = intval($_GET['page']);
			$currentPage = $currentPage > 0 ? $currentPage : 1;
			
		} else {
			$currentPage = 1;
		}

		$postdata['page'] = $currentPage;

		// 搜索关键字
		$keyname = isset($_GET['keyname']) ? new_addslashes($_GET['keyname']) : '';
		if($keyname){
			$postdata['searchWord'] = $keyname;
		}
		// 企业id
		$user_id = isset($_GET['enterprise_id']) ? intval($_GET['enterprise_id']) : '';
		if($user_id){
			$postdata['user_id'] = $user_id;
		}

		$products = $this->curl->post($url, $postdata);
		$products = json_decode($products, 1);

		$pages = pages($products['data']['total'], $currentPage, 10);
		$products = $products['data']['list'];

		
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'product_list', $default_style);
	}

	public function show(){

		$url = APP_URL.'api_product/getOne';
		$postdata['product_id'] = intval($_GET['id']);

		$product = $this->curl->post($url, $postdata);
		$product = json_decode($product, 1);
		if($product['code'] == 400) showmessage($product['msg'], HTTP_REFERER);
		$product = $product['data'];

		extract($product);
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'product_show', $default_style);
	}

	public function show_case(){
		$product_id = intval($_GET['id']);

		$db_product = pc_base::load_model('company_product_model');

		$where = array(
			'product_id' => $product_id,
			'status'=>'3'
		);

		$product = $db_product->get_one($where, 'product_name, cases');

		if(empty($product['cases']))
			showmessage('没有案例', HTTP_REFERER);

		$case = str_replace('/public/ueditor/image', APP_BASE_URL.'/public/ueditor/image', $product['cases']);
		$product_name = $product['product_name'];
		
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('app', 'product_case', $default_style);
	}
}