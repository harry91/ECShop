<?php

/**
 * ECSHOP 搜索程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: search.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

if (!function_exists("htmlspecialchars_decode"))
{
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
    {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

require(dirname(__FILE__) . '/includes/init.php');

assign_template();

if(!empty($_REQUEST['redirectByCarTypeName'])){
	$carCatName=$_REQUEST['redirectByCarTypeName'];
	$company=$_REQUEST['company'];
	$carCatId=$GLOBALS['db']->getOne("select cat_id from ecs_category where cat_name='".$carCatName."'");
	header('Location: '.'search.php?car_cat_level=5&car_category='.$carCatId.'&car_category_for_display='.rawurlencode($company." ".$carCatName));
	die();
}


$_REQUEST['vinCode'] = !empty($_REQUEST['vinCode']) ? trim($_REQUEST['vinCode']) : '';
$vinCode=$_REQUEST['vinCode'];

$options = array(
	'http' => array(
	'method' => 'GET',
	'header' => 'Content-type:application/text',
	'content' => '',
	'timeout' => 15
	)
);
$context = stream_context_create($options);
$result = file_get_contents("http://115.29.208.179/DataFunc?grantCode=is9krw6b&vinCode=".$vinCode, false, $context);

include_once('includes/cls_json.php');
$result=substr($result, 9, strlen($result) - 10);
$result=iconv('GBK', 'UTF-8', $result);
$result=json_decode($result, true);

$carTypeIndex=0;
foreach($result as $oneResult){
	$options = array(
		'http' => array(
		'method' => 'GET',
		'header' => 'Content-type:application/text',
		'content' => '',
		'timeout' => 15
		)
	);
	$context = stream_context_create($options);

	$imgResult = file_get_contents("http://112.124.115.17:8088/Web/Handler.ashx?name=picture&tid=".$oneResult["TID"] , false, $context);
	$imgResult=json_decode($imgResult, true);

	$oneResult["imgUrl"]="http://112.124.115.17:8088/车型图片/".$imgResult[1][2].".jpg";
	$result[$carTypeIndex]["imgUrl"]=$oneResult["imgUrl"];
	
	$result[$carTypeIndex]["searchUrl"]="searchCar.php?redirectByCarTypeName=".rawurlencode($result[$carTypeIndex]["车款名称"])."&company=".rawurlencode($result[$carTypeIndex]["厂商"]);
	$carTypeIndex++;

}

$smarty->assign('carTypes', $result);
$smarty->display('searchCar.dwt');
exit;

?>