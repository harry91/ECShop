<?php
//az_inserted
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

//处理AJAX请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'query_sub_car_types')
{
	$pageId=!empty($_GET['pageId']) ? $_GET['pageId'] : '1';
	$catId=$_GET['cat_id'];
	$catName=$_GET['cat_name'];
	$result['cat_id']=$catId;
	
	$resultIndex = 0;
	$carYears = '';
	$capacities='';
	$car_types =  getCategorySelection($catId);
	foreach($car_types as $one_car_type){
		$car_types_2 =  getCategorySelection($one_car_type['cat_id']);//年款
		foreach($car_types_2 as $one_car_type_2){
			if(!strstr($carYears, $one_car_type_2['cat_name'])){
				$carYears=$carYears.",".$one_car_type_2['cat_name'];
			}
			$car_types_3 = getCategorySelection($one_car_type_2['cat_id']);//排量
			foreach($car_types_3 as $one_car_type_3){
				if(!strstr($capacities, $one_car_type_3['cat_name'])){
					$capacities=$capacities.",".$one_car_type_3['cat_name'];
				}
				$car_types_4 = getCategorySelection($one_car_type_3['cat_id']);
				if(count($car_types_4) == 0){
					if($one_car_type['cat_name'] == "null_type"){
						$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'];
					}else{
						$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type['cat_name'].' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'];
					}
					$retTypes[$resultIndex]['cat_id']=$one_car_type_3['cat_id'];
					$resultIndex++;
				}else{
					foreach($car_types_4 as $one_car_type_4){
						if($one_car_type['cat_name'] == "null_type"){
							$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'].' '.$one_car_type_4['cat_name'];
						}else{
							$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type['cat_name'].' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'].' '.$one_car_type_4['cat_name'];
						}
						$retTypes[$resultIndex]['cat_id']=$one_car_type_4['cat_id'];
						$resultIndex++;
					}
				}
			}
		}
	}
	$result['car_types']=$retTypes;
	$result['carYears']=$carYears;
	$result['capacities']=$capacities;
	
	include_once('includes/cls_json.php');
	$json = new JSON;
    die($json->encode($result));
}
//完成AJAX请求的处理

assign_template();

$my_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = 1 ORDER BY CONVERT( cat_name USING gbk )";
$all_car_brands =  $GLOBALS['db']->getAll($my_sql);

for($i=0; $i<count($all_car_brands); $i++){
	$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$all_car_brands[$i]['cat_id'];
	$car_types =  $GLOBALS['db']->getAll($one_sql);
	$all_car_brands[$i]['car_types']=$car_types;
}

//print_r($all_car_brands);

$smarty->assign('all_car_brands', $all_car_brands);

$smarty->display('index.dwt');

function getCategorySelection($_cat_id){
	return $GLOBALS['db']->getAll("SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$_cat_id);
}

?>