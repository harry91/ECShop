<?php
//az_inserted

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

assign_template();

$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'get_cats_by_cat_name')
{
	$catName=$_GET['cat_name'];
	$catUid=$_GET['cat_uid'];
	
//	$sql="select cat_id from ecs_category where cat_name='$catName'";
//	$cat_id=$GLOBALS['db']->getOne($sql);
//	
//	$categories = get_goods_bottom_cat_ids(1, $cat_id);
//	
//	$subCategoriesSql = "select ecs_category_2.cat_id, ecs_category_2.cat_name from ecs_category ecs_category_2, ".
//			"(select distinct(ecs_category_1.parent_id) from ecs_category ecs_category_1 , ".
//		
//			"(SELECT distinct(g.cat_id) FROM ecs_goods AS g ".
//        	"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 ".
//        	"AND " . $categories . ") as goods ".
//		
//			"where ecs_category_1.cat_id = goods.cat_id) as ecs_category_1 ".
//			"where ecs_category_1.parent_id = ecs_category_2.cat_id";
//	
//	$all_cats =  $GLOBALS['db']->getAll($subCategoriesSql);

	$all_cats =  $GLOBALS['db']->getAll("select cat_name, cat_id from ecs_category where parent_id IN (select cat_id from ecs_category where cat_name = '$catName') and sort_order = 60");
	
	include('includes/cls_json.php');
    $json   = new JSON;
	$result['cat_name']=$catName;
	$result['all_cats']=$all_cats;
	$result['cat_uid']=$catUid;
	
	die($json->encode($result));
}

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