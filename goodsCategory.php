<?php
//az_inserted

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

assign_template();

$my_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = 2";
$all_gd_cate =  $GLOBALS['db']->getAll($my_sql);

for($i=0; $i<count($all_gd_cate); $i++){
	$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$all_gd_cate[$i]['cat_id'];
	$gd_types =  $GLOBALS['db']->getAll($one_sql);
	$all_gd_cate[$i]['gd_types']=$gd_types;
}

$smarty->assign('all_gd_cate', $all_gd_cate);

$smarty->display('goodsCategory.dwt');

?>