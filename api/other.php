<?php
/**
 * 获取联动菜单接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

switch($_GET['act']) {
	// 下载期刊
	case 'downPeriodical':
		downPeriodical();
		break;
	// 下载其他期刊
	case 'downOthers':
		downOthers();
		break;
		// 下一个期刊
	case 'getNextPeriodical':
		getNextPeriodical();
	break;

		// 下一个电子展讯或其他文件
	case 'getNextQikanOthers':
		getNextQikanOthers();
	break;

	// 下一个期刊
	case 'getNextReport':
		getNextReport();
	break;
}



/**
 * [downPeriodical 下载期刊]
 * @return [type] [0 下载 1 阅读 ]
 */
function downPeriodical(){

	$id = intval($_GET['id']);
	$type = $_GET['type'];

	$db_qikan = pc_base::load_model('qikan_model');
	$db_qikan_data = pc_base::load_model('qikan_data_model');

	$basicinfo = $db_qikan->get_one(array('id'=>$id), 'title');
	$info = $db_qikan_data->get_one(array('id'=>$id), 'qikanpath');

	if($info['qikanpath'] == '' || $info['qikanpath'] == '|') return false;
	$filepath = 'uploadfile'.rtrim($info['qikanpath'], '|');

	if ($type) 
	{ 
		$thefile = APP_PATH.$filepath;
		Header("HTTP/1.1 303 See Other"); 
		Header("Location: $thefile"); 
		exit; 
	}

	file_down($filepath, $basicinfo['title']);
	// $fileinfo = pathinfo($thefile);

	// header('Content-type: application/'.$fileinfo['extension']);
	// header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
	// header('Content-Length: '.filesize($filename));
	// readfile($thefile);
	// exit();
}
/**
 * [downPeriodical 下载电子版展讯或其他文件]
 * @return [type] [1 阅读 0 下载]
 */
function downOthers(){

	$id = $_GET['id'];
	$type = $_GET['type'];

	$db_qikan = pc_base::load_model('qikan_others_model');
	$db_qikan_data = pc_base::load_model('qikan_others_data_model');


	$basicinfo = $db_qikan->get_one(array('id'=>$id), 'title');
	$info = $db_qikan_data->get_one(array('id'=>$id), 'downfile');

	if($info['downfile'] == '' || $info['downfile'] == '|'){
		showmessage('文件不存在');
	}

	$filepath = 'uploadfile'.rtrim($info['downfile'], '|');
	if ($type) 
	{ 
		$thefile = APP_PATH.$filepath;
		Header("HTTP/1.1 303 See Other"); 
		Header("Location: $thefile"); 
		exit; 
	}
	
	file_down($filepath, $basicinfo['title']);
}

// 下一个期刊
function getNextPeriodical(){
	$db_qikan = pc_base::load_model('qikan_model');

	$page = $_POST['page'];
	$limit = $_POST['limit'];
	
	$limit_start = isMobile() ? ($page+1) : ($page+2);

	$infos = $db_qikan->select('', 'url, inputtime, thumb', "$limit_start,$limit", 'listorder desc, id desc');
	if(!empty($infos)){

		foreach ($infos as &$info) {
			$info['day'] = date('d', $info['inputtime']);
			$info['time'] = date('Y.m', $info['inputtime']);
		}

		if($limit  = 1)
			$infos = $infos[0];
		die(json_encode(array('code'=>200, 'data'=>$infos)));
	} else {
		die(json_encode(array('code'=>400)));
	}
}

// 下一个电子版展讯或期刊
function getNextQikanOthers(){
	$db_qikan_others = pc_base::load_model('qikan_others_model');


	$page = $_POST['page'];
	$limit = $_POST['limit'];
	
	$limit_start = isMobile() ? ($page+1) : ($page+2);

	$catid = $_POST['catid'];
	// $where['catid'] = $catid;
	$infos = $db_qikan_others->query("select qo.id, qo.title, qo.thumb, qo.inputtime, qod.downfile from phpcms_qikan_others qo left join phpcms_qikan_others_data qod on qo.id=qod.id where qo.catid=$catid order by qo.listorder desc, qo.id desc limit $limit_start,$limit")->fetch_array();
	// $infos = $db_qikan_others->select($where, 'title, thumb, downfile', "$limit_start,$limit", 'listorder desc, id desc');

	if(!empty($infos)){

		// foreach ($infos as &$info) {
			$infos['cut_title'] = strcut($infos['title'], 20);
			$infos['downfile'] = pc_base::load_config('system','upload_url').rtrim($infos['downfile']);
			$infos['day'] = date('d', $infos['inputtime']);
			$infos['time'] = date('Y.m', $infos['inputtime']);
		// }

		// if($limit  = 1)
		// 	$infos = $infos[0];
		die(json_encode(array('code'=>200, 'data'=>$infos)));
	} else {
		die(json_encode(array('code'=>400)));
	}
}

// 下一个报告
function getNextReport(){
	$report_model = pc_base::load_model('report_model');

	$page = $_POST['page'];
	$limit = $_POST['limit'];
	
	$limit_start = isMobile() ? ($page+1) : ($page+2);

	$infos = $report_model->select('', 'id, thumb, inputtime', "$limit_start,$limit", 'listorder desc, id desc');

	if(!empty($infos)){

		foreach ($infos as &$info) {
			$info['day'] = date('d', $info['inputtime']);
			$info['time'] = date('Y.m', $info['inputtime']);
		}

		if($limit  = 1)
			$infos = $infos[0];
		die(json_encode(array('code'=>200, 'data'=>$infos)));
	} else {
		die(json_encode(array('code'=>400)));
	}
}