<?php
//az_inserted
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

//处理AJAX请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'query_cats_of_brand')
{
	$brand_id=!empty($_GET['brand_id']) ? $_GET['brand_id'] : '1';
	$result['brand_id']=$brand_id;
	
	$queryCatsSql="select part.cat_id as partId, part.cat_name as partName, ".
					"subpart.cat_id as subPartId,  subpart.cat_name as subPartName, ".
					"accessory.cat_id as accessoryId, accessory.cat_name as accessoryName ".
					"from ecs_category as part ".
					"join ecs_category as subpart ".
					"on part.cat_id = subpart.parent_id ".
					"and part.parent_id =2 ".
					"join ecs_category as accessory ".
					"on subpart.cat_id = accessory.parent_id ".
					"and  accessory.cat_id in (select distinct cat_id from ecs_goods where brand_id = '$brand_id')";
	$result['goodsCats']=$GLOBALS['db']->getAll($queryCatsSql);
	
	include_once('includes/cls_json.php');
	$json = new JSON;
    die($json->encode($result));
}else if($act == 'query_goods_of_cat_brand'){
	$brand_id=!empty($_GET['brand_id']) ? $_GET['brand_id'] : '1';
	$cat_id=!empty($_GET['cat_id']) ? $_GET['cat_id'] : '-1';
	$cat_level=!empty($_GET['cat_level']) ? $_GET['cat_level'] : '0';
	
	if($cat_level == '0'){
		$queryGoodsSql="select goods_name, goods_id from ecs_goods where brand_id = '$brand_id' AND cat_id IN ( SELECT cat_id FROM ecs_category WHERE parent_id IN (SELECT cat_id FROM ecs_category WHERE parent_id = '$cat_id'))";
	}else if($cat_level == '1'){
		$queryGoodsSql="select goods_name, goods_id from ecs_goods where brand_id = '$brand_id' AND cat_id IN ( SELECT cat_id FROM ecs_category WHERE parent_id = '$cat_id')";
	}else if($cat_level == '2'){
		$queryGoodsSql="select goods_name, goods_id from ecs_goods where brand_id = '$brand_id' AND cat_id = '$cat_id'";
	}else if($cat_level == '3'){
		$queryGoodsSql="select goods_name, goods_id from ecs_goods where brand_id = '$brand_id'";
	}
	
	$result['goods']=$GLOBALS['db']->getAll($queryGoodsSql);
	
	include_once('includes/cls_json.php');
	$json = new JSON;
    die($json->encode($result));
}
//完成AJAX请求的处理

assign_template();

$my_sql = "select brand_id, brand_name from ecs_brand where brand_id IN(select distinct(brand_id) from ecs_goods where is_common = 1)";
$all_goods_brands =  $GLOBALS['db']->getAll($my_sql);

$smarty->assign('all_goods_brands', $all_goods_brands);

$smarty->display('goodsOfBrand.dwt');

//function getCategorySelection($_cat_id){
//	return $GLOBALS['db']->getAll("SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$_cat_id);
//}

?>
