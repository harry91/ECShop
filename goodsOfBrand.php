<?php
//az_inserted
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

//处理AJAX请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'query_goods_of_brand')
{
	$brand_id=!empty($_GET['brand_id']) ? $_GET['brand_id'] : '1';
	$result['brand_id']=$brand_id;
	
	$querySql="select goods_name, goods_id from ecs_goods where brand_id='$brand_id'";
	$result['goods']=$GLOBALS['db']->getAll($querySql);
	
	include_once('includes/cls_json.php');
	$json = new JSON;
    die($json->encode($result));
}
//完成AJAX请求的处理

assign_template();

$my_sql = "select brand_id, brand_name from ecs_brand where brand_id IN(select distinct(brand_id) from ecs_goods where is_common = 1)";
$all_goods_brands =  $GLOBALS['db']->getAll($my_sql);

//for($i=0; $i<count($all_car_brands); $i++){
//	$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$all_car_brands[$i]['cat_id'];
//	$car_types =  $GLOBALS['db']->getAll($one_sql);
//	$all_car_brands[$i]['car_types']=$car_types;
//}

//print_r($all_car_brands);

$smarty->assign('all_goods_brands', $all_goods_brands);

$smarty->display('goodsOfBrand.dwt');

//function getCategorySelection($_cat_id){
//	return $GLOBALS['db']->getAll("SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$_cat_id);
//}

?>
