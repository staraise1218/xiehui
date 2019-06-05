<?php 
/**
 *  会议支付回调	
 * @lastmodify			2010-7-26
 */
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';
$param = pc_base::load_sys_class('param');
 file_put_contents('caches/error_log.php',"\r\n".var_export(file_get_contents("php://input"), true), FILE_APPEND);



require_once ( './statics/plugin/payment/wxpay/WxPayConfig.php');
require_once ( './statics/plugin/payment/wxpay/MeetingPayNotify.php');
$config = new WxPayConfig();
$notify = new MeetingPayNotify();

return $notify->Handle($config, false);
?>