<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');

$u8ServiceUrl = "http://stahlgruber.cn:9765/services/stock/StockService";

//unittest3($u8ServiceUrl, $local_conn );
migrateGoods($u8ServiceUrl, $local_conn );
function unittest($u8ServiceUrl){
    // verify system can return non-common product
	$goodsId = '1000009';
	$goods = getGoodsFromU8($goodsId, $u8ServiceUrl);
	echo goodsToString($goods);
}

function unittest2($u8ServiceUrl){
   // verify system can return common product
	$goodsId = '1000401';
	$goods = getGoodsFromU8($goodsId, $u8ServiceUrl);
	echo goodsToString($goods);
}

function unittest3($u8ServiceUrl,$local_conn){
   // verify system can migrate common product
	$goodsId = '1000401';
	migrateOneGoods($goodsId, $u8ServiceUrl,$local_conn);		
}



function goodsToString($goods){
   $str = 'provider name: '.$goods->goodsList->goods->provider_name.
          ', goods name:' .$goods->goodsList->goods->goods_name.
		  ', brand name: '.$goods->goodsList->goods->brand_name.
		  ', unit name: '.$goods->goodsList->goods->unit_name.
		  ', stock code:'.$goods->goodsList->goods->stock_code.
		  ', is_common: '.$goods->goodsList->goods->is_common;
   return $str;
}


function migrateGoods($u8ServiceUrl, $local_conn){
	$result = getAllGoodsIds($u8ServiceUrl);
	
	$goodsIds = $result->Stock->stock;
	$count = count($goodsIds);
	
	echo 'total goods '.$count.'<br/>';	
	for ($i = 0; $i < $count ; $i++) {
		echo 'goods id: '.$goodsIds[$i]->cInvCode.'<br/>';
		migrateOneGoods($goodsIds[$i]->cInvCode, $u8ServiceUrl, $local_conn);		
	}

}

// migrate a goods from u8 to ecommerce database	
function migrateOneGoods($goodsId,$u8ServiceUrl,$local_conn) {
	$goodsResult = getGoodsFromU8($goodsId, $u8ServiceUrl);	
	$goodsPriceResult = getGoodsPriceFromU8($goodsId, $u8ServiceUrl);	
	$price =0;
	if($goodsPriceResult->goodsList) {
		$price = $goodsPriceResult->goodsList->goods->price;
	}
	
	if ($goodsResult->goodsList) {	
		createOrUpdateGoods($goodsId, $goodsId,
				$goodsResult->goodsList->goods->provider_name, 
			$goodsResult->goodsList->goods->goods_name,
			$goodsResult->goodsList->goods->brand_name,
			$goodsResult->goodsList->goods->stock_code, 
			$price,$goodsResult->goodsList->goods->is_common, $local_conn);			
		}
}


function getGoodsPriceFromU8($goods_id , $u8ServiceUrl){
	$postdata = '{"getGoodsPrice":{"cInvCode":"'.$goods_id.'" }}';
	$options = array(
		'http' => array(
		'method' => 'POST',
		'header' => 'Content-type:application/json',
		'content' => $postdata,
		'timeout' => 60
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

function createOrUpdateGoods($goods_id, $goods_sn,$provider_name, $goods_name,$brand_name,
			$stock_code, $shop_price, $is_common, $local_conn){
			$tmp_goods_cat_id = 1;
	
		
	$queryStr="INSERT INTO ecs_goods".
	" (goods_id, goods_sn,  provider_name,  goods_name,  stock_code,  shop_price,  brand_name,  unit_name, unit_format, goods_number, cat_id, ".
	"keywords, goods_brief, goods_desc, goods_thumb, goods_img, original_img, extension_code, seller_note, is_common )".
	"VALUES".
	" ($goods_id, '$goods_sn','$provider_name','$goods_name','$stock_code','$shop_price','$brand_name','','',0,'$tmp_goods_cat_id',".
	"'', '', '', '', '', '', '', '', '$is_common' )";
	
	//echo $queryStr;
	$local_conn->query($queryStr);
	clearStoredResults($local_conn);
	
	
}

?>