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
	$car_types =  getCategorySelection($catId);//年款
	//print_r($car_types);
	
	foreach($car_types as $one_car_type){
		if(!strstr($carYears, $one_car_type['cat_name'])){
			$carYears=$carYears.",".$one_car_type['cat_name'];
		}
		$car_types_2 =  getCategorySelection($one_car_type['cat_id']);//排量
		foreach($car_types_2 as $one_car_type_2){
			if(!strstr($capacities, $one_car_type_2['cat_name'])){
				$capacities=$capacities.",".$one_car_type_2['cat_name'];
			}
			$car_types_3 = getCategorySelection($one_car_type_2['cat_id']);//车型
			foreach($car_types_3 as $one_car_type_3){
				$retTypes[$resultIndex]['attributes']=$catName.' '.$one_car_type['cat_name'].' '.$one_car_type_2['cat_name'];
				$retTypes[$resultIndex]['name']=$one_car_type_3['cat_name'];
				$retTypes[$resultIndex]['cat_id']=$one_car_type_3['cat_id'];
				$resultIndex++;
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

$my_sql = "SELECT cat_name, cat_id, cat_desc FROM ecs_category WHERE parent_id = 1 ORDER BY cat_desc"; //CONVERT( cat_name USING gbk )";
$all_car_brands =  $GLOBALS['db']->getAll($my_sql);

for($i=0; $i<count($all_car_brands); $i++){
	$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$all_car_brands[$i]['cat_id'];
	$car_types =  $GLOBALS['db']->getAll($one_sql);
	$all_car_brands[$i]['car_types']=$car_types;
	$all_car_brands[$i]['first_char']=$all_car_brands[$i]['cat_desc']; //getfirstchar($all_car_brands[$i]['cat_name']);
}

//print_r($all_car_brands);

$smarty->assign('all_car_brands', $all_car_brands);

$smarty->display('index.dwt');

function getCategorySelection($_cat_id){
	return $GLOBALS['db']->getAll("SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$_cat_id);
}

//return the first letter of chinese in pinyin
function getfirstchar($s0){   
	$fchar = ord($s0{0});
	if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
	$s1 = iconv("UTF-8","gb2312", $s0);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $s0){$s = $s1;}else{$s = $s0;}
	$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
	if($asc >= -20319 and $asc <= -20284) return "A";
	if($asc >= -20283 and $asc <= -19776) return "B";
	if($asc >= -19775 and $asc <= -19219) return "C";
	if($asc >= -19218 and $asc <= -18711) return "D";
	if($asc >= -18710 and $asc <= -18527) return "E";
	if($asc >= -18526 and $asc <= -18240) return "F";
	if($asc >= -18239 and $asc <= -17923) return "G";
	if($asc >= -17922 and $asc <= -17418) return "H";
	if($asc >= -17417 and $asc <= -16475) return "J";
	if($asc >= -16474 and $asc <= -16213) return "K";
	if($asc >= -16212 and $asc <= -15641) return "L";
	if($asc >= -15640 and $asc <= -15166) return "M";
	if($asc >= -15165 and $asc <= -14923) return "N";
	if($asc >= -14922 and $asc <= -14915) return "O";
	if($asc >= -14914 and $asc <= -14631) return "P";
	if($asc >= -14630 and $asc <= -14150) return "Q";
	if($asc >= -14149 and $asc <= -14091) return "R";
	if($asc >= -14090 and $asc <= -13319) return "S";
	if($asc >= -13318 and $asc <= -12839) return "T";
	if($asc >= -12838 and $asc <= -12557) return "W";
	if($asc >= -12556 and $asc <= -11848) return "X";
	if($asc >= -11847 and $asc <= -11056) return "Y";
	if($asc >= -11055 and $asc <= -10247) return "Z";
	return null;
}

?>