<?php
/**
 *  index.php PHPCMS 入口

 * @lastmodify			2010-6-1
 */
 //PHPCMS根目录

define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include PHPCMS_PATH.'/phpcms/base.php';

pc_base::creat_app();

?>