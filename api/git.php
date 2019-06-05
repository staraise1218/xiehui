<?php
/**
 * 自动同步git
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

$output = shell_exec("cd /home/www/xiehui; ls");
echo "<pre>$output</pre>";

file_put_contents('./log.txt', date('Y-m-d H:i:s'));