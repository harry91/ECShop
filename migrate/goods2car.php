<?php
$StartTime = time();

header ( "Content-type: text/html; charset=utf-8" );
require (dirname ( __FILE__ ) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');
require_once (dirname ( __FILE__ ) . '/ecshop_goods.php');

mapGoodsToCar($local_conn, $timex_conn);

//unittest($local_conn, $timex_conn);
//unittest2($local_conn, $timex_conn);

function unittest($local_conn, $timex_conn) {	
	$brandCode = 'OC 1022';
	$brandName = '马勒(MAHLE)';
	$carIdArr = getBrandItem2Car($timex_conn, $brandName, $brandCode);	
	if(is_null($carIdArr)) {
		echo 'timex api does not return available cars for goods, brand code: '
				.$brandCode.', brand name: '.$brandName.'<br/>';
	} else {
		echo 'timex can return cars list, the car ids: '.arrToStr($carIdArr).'<br/>';
	}
}

function unittest2($local_conn, $timex_conn) {	
	$brandCode = '23647-PPP-000';
	$brandName = '原厂';
	$carIdArr = getOemItem2Car($timex_conn, $goodsArr[$i]->brandCode);	
	if(is_null($carIdArr)) {
		echo 'timex api does not return available cars for goods, brand code: '
				.$brandCode.', brand name: '.$brandName.'<br/>';
	} else {
		echo  'timex can return cars list, the car ids: '.arrToStr($carIdArr).'<br/>';
	}
}



function mapGoodstoCar($local_conn, $timex_conn){
	$goodsArr = getAllGoods($local_conn);
	$goodsCount = count($goodsArr);
	for ($i = 0; $i <$goodsCount; $i++) {		
		$tidArr = null;		
		// excel 中,如果是原厂件,则brandName 是特殊的值 			
		if ($goodsArr[$i]->brandName == "原厂"){
			$tidArr = getOemItem2Car($timex_conn, $goodsArr[$i]->brandCode);
		} else {		
			$tidArr = getBrandItem2Car($timex_conn, $goodsArr[$i]->brandName, $goodsArr[$i]->brandCode);
		}
		
		if(is_null($tidArr)) {
			echo 'timex api does not return available cars for goods, brand code: '
				.$goodsArr[$i]->brandCode.', name: '.$goodsArr[$i]->brandName.'<br/>';
			continue;
		}
		$carIdArr = null;
		$carIdArr = getCarIdByTimexId($local_conn, $tidArr);
		
		if(is_null($carIdArr)) {
			echo 'local database does not exist car data '.arrToStr($tidArr) . ' for goods, brand code:'.
			$goodsArr[$i]->brandCode.', name: '.$goodsArr[$i]->brandName.'<br/>' ;
			continue;
		}
		
		addGoods2Car($local_conn, $goodsArr[$i]->goodsId, $carIdArr);
		
	}
}

function getOemItem2Car($timex_conn, $brandCode){
	$queryStr =  "CALL p_searchTidByKpsCode('". $brandCode ."', @res)";	
	$queryResult = $timex_conn->query($queryStr);	
	$tidArr = null;
	if ($queryResult && $queryResult->num_rows > 0){				
		$index = 0;
		while($row = $queryResult->fetch_array() ){
			$tidArr[$index] = $row[2];		
			$index++;					
		}	
	}
	clearStoredResults($timex_conn);
	return $tidArr;	
}

function getBrandItem2Car($timex_conn, $brandName, $brandCode){		
	$queryStr =  "CALL p_searchTidBykpsCodeBrand( '".$brandCode."','".$brandName."', @res)";	
	//echo $queryStr;	
	$queryResult = $timex_conn->query($queryStr);	
	$tidArr = null;
	if ($queryResult && $queryResult->num_rows > 0){				
		$index = 0;
		
		while($row = $queryResult->fetch_array() ){
			$tidArr[$index] = $row[5];					
			$index++;		
		}	
	}
	clearStoredResults($timex_conn);
	return $tidArr;	
}


function arrToStr($tidArr) {
	$varStr = '';
	if(is_null($tidArr)){
		return $varStr;
	}
	$len = count($tidArr);
	for($i =0; $i < $len; $i++){
		$varStr = $varStr.','.$tidArr[$i];
	}
	
	return $varStr;
}
