<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 一起点亮中国文旅地图
 */

$guoqing_model = pc_base::load_model('guoqing_model');

$data = $_POST;

$guoqing_model->insert($data);
die(json_encode(array('code'=>200)));