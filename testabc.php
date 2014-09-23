<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

assign_template();

$position = assign_ur_here('', '啦啦啦');

$smarty->assign('ur_here',          $position['ur_here']);  // 当前位

$smarty->display('testabc.dwt');

?>