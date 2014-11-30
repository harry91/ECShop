<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');

$u8ServiceUrl = "http://stahlgruber.cn:9765/services/stock/StockService";
	
$result = getAllGoodsIds($u8ServiceUrl);
$goodsIds = $result->Stock->stock;
$count = count($goodsIds);

for ($i = 0; $i < $count; $i++) {
	$goodsResult = getGoodsFromU8($goodsIds[$i]->cInvCode, $u8ServiceUrl);
	
	$goodsPriceResult = getGoodsPriceFromU8($goodsIds[$i]->cInvCode, $u8ServiceUrl);
	
	if ($goodsResult->goodsList->goods not null) {
	
		createGoods($goodsIds[$i]->cInvCode, $goodsIds[$i]->cInvCode,
				$goodsResult->goodsList->goods->provider_name, 
			$goodsResult->goodsList->goods->goods_name,
			$goodsResult->goodsList->goods->brand_name,
			$goodsResult->goodsList->goods->stock_code, 
			$goodsPriceResult->goodsList->goods->price, $local_conn);
			
	}		
}	

function migrateGoodsId($local_conn, $u8ServiceUrl){
	$result = getAllGoodsIds($u8ServiceUrl);
	$goodsIds = $result->Stock->stock;
	$count = count($goodsIds);

	for ($i = 0; $i < $count; $i++) {
		$queryStr="INSERT INTO ecs_tmp_goods_id (goods_id)"."values(".$goodsIds[$i]->cInvCode.")";		
		$local_conn->query($queryStr); 	
		clearStoredResults($local_conn);
	}
	echo 'total '.$count .' of goods from u8';
}


function getGoodsPriceFromU8($goods_id , $u8ServiceUrl){
	$postdata = '{"getGoodsPrice":{"cInvCode":"'.$goods_id.'" }}';
	$options = array(
		'http' => array(
		'method' => 'POST',
		'header' => 'Content-type:application/json',
		'content' => $postdata,
		'timeout' => 15
		)
	);
	$context = stream_context_create($options);
	$result = file_get_contents($u8ServiceUrl, false, $context);
	$result = json_decode($result);
	return $result;
}


function getGoodsFromU8($goods_id , $u8ServiceUrl){
	$postdata = '{"getGoods":{"cInvCode":"'.$goods_id.'" }}';
	$options = array(
		'http' => array(
		'method' => 'POST',
		'header' => 'Content-type:application/json',
		'content' => $postdata,
		'timeout' => 15
		)
	);
	$context = stream_context_create($options);
	$result = file_get_contents($u8ServiceUrl, false, $context);
	$result = json_decode($result);
	return $result;
}


function getAllGoodsIds($u8ServiceUrl){
	$postdata = '{"getAllGoods":{}}';
	$options = array(
		'http' => array(
		'method' => 'POST',
		'header' => 'Content-type:application/json',
		'content' => $postdata,
		'timeout' => 15
		)
	);
	$context = stream_context_create($options);
	$result = file_get_contents($u8ServiceUrl, false, $context);
	$result = json_decode($result);
	return $result;
}

function createGoods($goods_id, $goods_sn,$provider_name, $goods_name,$brand_name,
			$stock_code, $shop_price, $local_conn){
			$tmp_goods_cat_id = 1;
	$queryStr="INSERT INTO ecs_goods".
	" (goods_id, goods_sn,  provider_name,  goods_name,  stock_code,  shop_price,  brand_name,  unit_name, unit_format, goods_number, cat_id, ".
	"keywords, goods_brief, goods_desc, goods_thumb, goods_img, original_img, extension_code, seller_note )".
	"VALUES".
	" ($goods_id, '$goods_sn','$provider_name','$goods_name','$stock_code','$shop_price','$brand_name','','',0,'$tmp_goods_cat_id',".
	"'', '', '', '', '', '', '', '' )";
	echo $queryStr;
	$local_conn->query($queryStr);
	clearStoredResults($local_conn);
	
}

?>