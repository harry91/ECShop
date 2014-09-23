<?php
//az_inserted

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

assign_template();

$queryCategoriesSql="select cat_id, cat_name from ecs_category where parent_id = 2";

$allCategories=$GLOBALS['db']->getAll($queryCategoriesSql);

for($i=0; $i<count($allCategories); $i++){
	$one_sql = "SELECT brand_id, brand_name FROM ecs_brand2category WHERE ecs_brand2category.cat_id = ".$allCategories[$i]['cat_id'];
	$car_types =  $GLOBALS['db']->getAll($one_sql);
	$all_car_brands[$i]['car_types']=$car_types;
}

$smarty->display('goodsBrand.dwt');

?>