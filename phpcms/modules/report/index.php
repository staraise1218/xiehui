<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
class index {
	private $db;
	function __construct() {
		$this->db = pc_base::load_model('report_model');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
		
	}

	public function buy(){
		$id = input('id/d');
		
		// 报告信息
		$report = $this->db->get_one(array('id'=>$id));

		//SEO
		$SEO = seo(SITEID);
		$cat_id = 38;
		$CATEGORYS = getcache('category_content_'.SITEID,'commons');

		$default_style = isMobile() ? 'mobile' : 'default';
		include template('report','buy',$default_style);
	}

	/**
	 * [dosubmit 下订单]
	 * @return [type] [description]
	 */
	public function dosubmit(){
		$report_id = input('post.report_id');
		$fullname = input('post.fullname');
		$company = input('post.company');
		$invoice_info = input('post.invoice_info');
		$contact = input('post.contact');
		$machine_code = input('post.machine_code');
		$is_member = input('post.is_member');

		if($fullname == '') die(json_encode(array('code'=>400, 'msg'=>'姓名不能为空')));
		if($contact == '') die(json_encode(array('code'=>400, 'msg'=>'联系方式不能为空')));

		// 报告数据
		$report = $this->db->get_one(array('id'=>$report_id));
		if(empty($report) || $report['is_show'] == 0) die(json_encode(array('code'=>400, 'msg'=>'报告已禁止购买')));
		// 报告订单模型
		$report_order_model = pc_base::load_model('report_order_model');

		$order_sn = $this->generateOrdersn();
		$order_data = array(
			'order_sn' => $order_sn,
			'report_id' => $report_id,
			'fullname' => $fullname,
			'company' => $company,
			'invoice_info' => $invoice_info,
			'contact' => $contact,
			'machine_code' => $machine_code,
			'is_member' => $is_member,
			'price' => $is_member ? $report['price'] : $report['nomember_price'],
			'createtime' => time(),
		);

		if($report_order_model->insert($order_data)){
			die(json_encode(array('code'=>200, 'order_sn'=>$order_sn)));
		}
	}


	function generateOrdersn(){
		 $order_sn = null;
	    // 保证不会有重复订单号存在
	    while(true){
	        $order_sn = date('YmdHis').rand(1000,9999); // 订单编号	 
	        $report_order_model = pc_base::load_model('report_order_model');
	        $order_sn_count = $report_order_model->count("order_sn = ".$order_sn);
	        if($order_sn_count == 0)
	            break;
	    }
	    
	    return $order_sn;
	}

}