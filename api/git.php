<?php
/**
 * 自动同步git
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

$output = system("cd /home/www/xiehui; git pull 2>&1");
echo "<pre>$output</pre>";

file_put_contents('./log.txt', date('Y-m-d H:i:s'));