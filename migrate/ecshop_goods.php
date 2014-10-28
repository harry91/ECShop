<?php

class Goods {
	public $goodsId;
	public $brandCode;
	public $brandName;
}

class GoodsIdCarId {
	public $goodsId;
	public $carId;
}

function getJustImportedGoods($mysqli_link){
    // "stock code" and "brand name" is the key to query timex api to get category information. 
	// "cat =1" 是在商品从excel导入的时候, 指定的一个cat Id
	$queryStr = "select goods_id, stock_code, brand_name from ecs_goods where cat_id = 1";	
	$queryResult = $mysqli_link->query($queryStr);

	if ($queryResult && $queryResult->num_rows > 0){
		$index = 0;
		while($category1Row = $queryResult->fetch_array() ){
			$goods = new Goods();		
			$goods->goodsId = $category1Row[0];			
			$goods->brandCode = $category1Row[1];
			$goods->brandName = $category1Row[2];
			$goodsArr[$index] =$goods;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $goodsArr;
}


function getBrandIsNullGoods($mysqli_link){
    // "stock code" and "brand name" is the key to query timex api to get category information. 
	// "cat =1" 是在商品从excel导入的时候, 指定的一个cat Id
	$queryStr = "select goods_id, stock_code, brand_name from ecs_goods where brand_id = 0";	
	$queryResult = $mysqli_link->query($queryStr);

	if ($queryResult && $queryResult->num_rows > 0){
		$index = 0;
		while($category1Row = $queryResult->fetch_array() ){
			$goods = new Goods();		
			$goods->goodsId = $category1Row[0];			
			$goods->brandCode = $category1Row[1];
			$goods->brandName = $category1Row[2];
			$goodsArr[$index] =$goods;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $goodsArr;
}


function getAllGoods($mysqli_link){
    // "stock code" and "brand name" is the key to query timex api to get category information. 
	// "cat =1" 是在商品从excel导入的时候, 指定的一个cat Id
	$queryStr = "select goods_id, stock_code, brand_name from ecs_goods";	
	$queryResult = $mysqli_link->query($queryStr);

	if ($queryResult && $queryResult->num_rows > 0){
		$index = 0;
		while($category1Row = $queryResult->fetch_array() ){
			$goods = new Goods();		
			$goods->goodsId = $category1Row[0];			
			$goods->brandCode = $category1Row[1];
			$goods->brandName = $category1Row[2];
			$goodsArr[$index] =$goods;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $goodsArr;
}

function isExistGoodsBySn($mysqli_link, $goodsSn ){
	$queryStr = "select count(*) from ecs_goods where goods_sn='".$goodsSn."'";	
	$result = $mysqli_link->query($queryStr);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();		
		if ($row[0] >0) {
			$ret = true;	
		}		
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}

function updateCategory($mysqli_link, $goodId, $categoryId){
	
	$queryStr = "update ecs_goods set cat_id = ".$categoryId." where  goods_id = ".$goodId;		
	$queryResult = $mysqli_link->query($queryStr);
}


function updateGoodsBrand($mysqli_link, $goodId, $categoryId){	
	$queryStr = "update ecs_goods set brand_id = ".$categoryId." where  goods_id = ".$goodId;		
	$queryResult = $mysqli_link->query($queryStr);
}



function updateGoodsIsCommon($mysqli_link, $goodsSn, $isCommon){	
	$queryStr = "update ecs_goods set is_common = ".$isCommon." where  goods_sn = '".$goodsSn."'";		
	echo $queryStr.'<br/>';
	$queryResult = $mysqli_link->query($queryStr);
}

function addGoods2Car($mysqli_link, $goodsId, $carIdsArr) {
	$count = count($carIdsArr) ;
	for($i =0; $i < $count; $i++){
		if(isExistGoodsCar($mysqli_link, $goodsId, $carIdsArr[$i])) {
			continue;
		}
		insertGoods2Car($mysqli_link, $goodsId, $carIdsArr[$i]);		
	}
}

function insertGoods2Car($mysqli_link, $goodsId, $carId) {

	$queryStr = "insert into ecs_goods_cat values (".$goodsId.", ".$carId.")";		
	$result = $mysqli_link->query($queryStr);	
	clearStoredResults($mysqli_link);		
}

function isExistGoodsCar($mysqli_link, $goodsId, $carId) {
	
	$queryStr = "select count(*) from ecs_goods_cat where goods_id=".$goodsId." and cat_id=".$carId;				
	$result = $mysqli_link->query($queryStr);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();				
		if ($row[0] >0) {
			$ret = true;	
		}		
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}



?>