	<?php
$StartTime = time();

header ( "Content-type: text/html; charset=utf-8" );
require (dirname ( __FILE__ ) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');
require_once (dirname ( __FILE__ ) . '/ecshop_goods.php');

mapGoodsToCar($local_conn, $timex_conn);






function mapGoodstoCar($local_conn, $timex_conn){
	$goodsArr = getAllGoods($local_conn);
	$goodsCount = count($goodsArr);
	for ($i = 0; $i < $goodsCount; $i++) {		
		$tidArr = null;		
		// excel 中,如果是原厂件,则brandName 是特殊的值 		
		if ($goodsArr[$i]->brandName == "原厂件"){
			$tidArr = getOemItem2Car($timex_conn, $goodsArr[$i]->brandCode);
		} else {
			$tidArr = getBrandItem2Car($timex_conn, $goodsArr[$i]->brandName, $goodsArr[$i]->brandCode);
		}
		
		if(is_null($tidArr)) {
			echo 'timex api dooes not return available cars';
			continue;
		}
		$carIdArr = null;
		$carIdArr = getCarIdByTimexId($local_conn, $tidArr);
		
		if(is_null($carIdArr)) {
			echo 'local database does not exist car data '.arrToStr($tidArr) .'<br/>' ;
			continue;
		}
		
		addGoods2Car($local_conn, $goodsArr[$i]->goodsId, $carIdArr);
		
	}
}

function getOemItem2Car($timex_conn, $brandCode){
	$queryStr =  "CALL p_searchTidByKpsCode('". $brandCode ."', @res)";
	$queryStr =  "CALL p_searchTidByKpsCodeDealer( '". $brandCode."', @res)";	
	$queryResult = $timex_conn->query($queryStr);	
	
	if ($queryResult && $queryResult->num_rows > 0){				
		$index = 0;
		while($row = $queryResult->fetch_array() ){
			$tidArr[$index] = $row[0];		
			$index++;		
		}	
	}
	clearStoredResults($timex_conn);
	return $tidArr;	
}

function getBrandItem2Car($timex_conn, $brandName, $brandCode){	
	// need to ask timex to add brand name, so far is not use
	$queryStr =  "CALL p_searchTidByKpsCodeDealer( '". $brandCode."', @res)";	
	$queryResult = $timex_conn->query($queryStr);	
	
	if ($queryResult && $queryResult->num_rows > 0){				
		$index = 0;
		while($row = $queryResult->fetch_array() ){
			$tidArr[$index] = $row[0];		
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
