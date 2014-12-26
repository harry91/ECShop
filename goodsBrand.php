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

$my_sql = "select brand_id, brand_name, brand_logo from ecs_brand ORDER BY CONVERT( brand_name USING gbk )";// where brand_id IN(select distinct(brand_id) from ecs_goods where is_common = 1)";
$all_goods_brands =  $GLOBALS['db']->getAll($my_sql);

for($i=0; $i<count($all_goods_brands); $i++){
	$all_goods_brands[$i]['first_char']=getfirstchar($all_goods_brands[$i]['brand_name']);
}

$smarty->assign('all_goods_brands', $all_goods_brands);

$smarty->display('goodsBrand.dwt');

//function getCategorySelection($_cat_id){
//	return $GLOBALS['db']->getAll("SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$_cat_id);
//}

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
