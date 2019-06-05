<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class report extends admin {
	private $db;
	private $report_order_model;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('report_model');
		$this->report_order_model = pc_base::load_model('report_order_model');
	}

	public function orderlist(){
		$show_header = $show_dialog = '';
		// 搜索
		
		$keyword = input('keyword');

		$where = "pay_status = 1";
		if($_GET['search']){
			$searchtype = input('searchtype');
			
			if($keyword){
				($searchtype == 'fullname') &&  $where .= " and ro.fullname like '%$keyword%'";
				($searchtype == 'contact') &&  $where .= " and ro.contact = '$keyword'";
				($searchtype == 'report_name') &&  $where .= " and r.title like '%$keyword%'";
			}
		}


		// 分页
		$sql = "SELECT count(1) count  FROM phpcms_report_order ro LEFT JOIN phpcms_report r on ro.report_id=r.id WHERE {$where}";
		$this->db->query($sql);
		$taota_count = $this->db->fetch_array();
		$count = $taota_count[0]['count'];

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pernum = 20;
		$limit_start = ($page-1)*$pernum;
		
		$pages = pages($count, $page, $pernum);

		$sql = "SELECT r.title, ro.*  FROM phpcms_report_order ro LEFT JOIN phpcms_report r on ro.report_id=r.id WHERE {$where} order by ro.id desc limit {$limit_start}, $pernum";

		$this->db->query($sql);
		$list = $this->db->fetch_array();

		pc_base::load_sys_class('form');
		include $this->admin_tpl('orderlist');
	}


	public function ajax_change_shipping_status(){
		$id  = input('id');
		$shipping_status = input('shipping_status');
		if($shipping_status == 0){
			$updatedata['shipping_time'] = NULL;
		}
		if($shipping_status == 1){
			$updatedata['shipping_time'] = time();
		}
		$updatedata['shipping_status'] = $shipping_status;

		$this->report_order_model->update($updatedata, array('id'=>$id));
	}

	public function orderDetail(){
		$id = input('id');

		$info = $this->report_order_model->get_one(array('id'=>$id));

		include $this->admin_tpl('orderDetail');
	}
}