<?php
//az_inserted

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

assign_template();

$queryCategoriesSql="select cat_id, cat_name from ecs_category where parent_id = 2";

$allCategories=$GLOBALS['db']->getAll($queryCategoriesSql);

for($i=0; $i<count($allCategories); $i++){
	$one_sql = "SELECT ecs_brand.brand_id, ecs_brand.brand_name, ecs_brand.brand_logo FROM ecs_brand2category, ecs_brand ".
	"WHERE ecs_brand.brand_id = ecs_brand2category.brand_id AND cat_id = ".$allCategories[$i]['cat_id'];
	$brands =  $GLOBALS['db']->getAll($one_sql);
	$allCategories[$i]['brands']=$brands;
}
$smarty->assign('allCategories', $allCategories);
$smarty->display('goodsBrand.dwt');

?>