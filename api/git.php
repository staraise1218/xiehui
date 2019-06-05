<?php
/**
 * 自动同步git
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

$output = shell_exec("cd /home/www/xiehui; git pull ");
var_dump($output);
echo "<pre>$output</pre>";