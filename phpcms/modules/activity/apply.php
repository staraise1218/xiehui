<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class apply extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('activity_apply_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';

		$table_type = $_GET['table_type'];

		$where = "table_type ='{$table_type}'";
		if(isset($_GET['local_type']) && $_GET['local_type'] != ''){
			$search['local_type'] = $_GET['local_type'];
			$local_type = $_GET['local_type'];
			$where .= " and local_type='{$local_type}'";
		}
		// 支付状态
		if(isset($_GET['pay_status'])){
			
			$pay_status = $_GET['pay_status'];
			if($pay_status == 1) $where .= " and pay_status =1";
			if($pay_status == 0) $where .= " and pay_status =0";
		}

		$searchtype = input('searchtype');
		if($_GET['search']){
			$keyword = $_GET['keyword'];
			if($keyword){
				($searchtype == 'contact_name') &&  $where .= " and contact_name like '%$keyword%'";
				($searchtype == 'unit_name') &&  $where .= " and unit_name like '%$keyword%'";
				($searchtype == 'contact_phone') &&  $where .= " and contact_phone = '$keyword'";
			}
		}

		// p($_GET,$where);

		$table_name = ($table_type == 'exhibition') ? '展会' : '论坛';

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$limit = 20;
		$infos = $this->db->listinfo($where, $order = 'id desc', $page, $limit);
		$pages = $this->db->pages;

		include $this->admin_tpl('apply_list');
	}
 
	public function details() {


		$show_validator = $show_scroll = $show_header = true;
		pc_base::load_sys_class('form', '', 0);
	
		//解出内容
		$info = $this->db->get_one(array('id'=>$_GET['id']));
		if(!$info) showmessage('数据不存在');

		$info = new_stripslashes($info);
		extract($info); 

		include $this->admin_tpl('apply_details');


	}
}