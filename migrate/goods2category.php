	<?php
$StartTime = time();

header ( "Content-type: text/html; charset=utf-8" );
require (dirname ( __FILE__ ) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');
require_once (dirname ( __FILE__ ) . '/ecshop_goods.php');


updateGoodsCategory($local_conn, $timex_conn);

function updateGoodsCategory($local_conn, $timex_conn){
	$goodsArr = getJustImportedGoods($local_conn);
	$goodsCount = count($goodsArr);
	for ($i = 0; $i < $goodsCount; $i++) {	
		$accessoryId = getCategoryId($timex_conn, $local_conn, $goodsArr[$i]->brandName, $goodsArr[$i]->brandCode);
		if ($accessoryId <> -1) {
			updateCategory($local_conn, $goodsArr[$i]->goodsId, $accessoryId);		
		}
	}
}

function unittest($local_conn, $timex_conn){
	$code = 'OC 730';
	$brand = '马勒(MAHLE)';
	$categoryId = getCategoryId($timex_conn, $local_conn, $code,$brand);	
}

function unittest2($local_conn, $timex_conn){
	$code = 'KI 14';
	$brand = '马勒(MAHLE)';
	$categoryId = getCategoryId($timex_conn, $local_conn, $code,$brand);	
	
}


function getCategoryId($timex_conn, $local_conn, $goodsBrandCode,$goodsBrandName){
	$accessorId = -1;
	if ($goodsBrandName == "原厂"){
		$timexCategory = getOemItemCategory($timex_conn, $goodsBrandCode);
	} else {
		$timexCategory = getBrandItemCategory($timex_conn, $goodsBrandName, $goodsBrandCode);
	}
	if($timexCategory->accessory == "unset") {
		echo 'timex cannot find category for brand item: '. $goodsBrandCode.', and brand name:'.$goodsBrandName.'<br/>' ;
		return $accessorId;
	}
	$accessoryId = getCatIdByAccessoryAndSubPart($local_conn, $timexCategory->subPart, $timexCategory->accessory);
	if($accessoryId == -1) {
		echo 'local database does not exist part '.
					$timexCategory->part.', and subpart '.
					$timexCategory->subPart.', and accessory:'.$timexCategory->accessory. 
					' for goods which brand code is: '.$goodsBrandCode.', and brand name is:'.$goodsBrandName.'<br/>' ;	
	}		
	return $accessoryId;
}


class TimexCategory {
	public $part;
	public $subPart;
	public $accessory;
}

function getOemItemCategory($timex_conn, $brandCode){
	$queryStr =  "CALL p_apl_getKpsByKpsCode('". $brandCode ."', @res)";
	$queryResult = $timex_conn->query($queryStr);
	$timexCategory = new TimexCategory();	
	$timexCategory->accessory = "unset";
	if ($queryResult && $queryResult->num_rows > 0){		
		//if timex return multiple row, then we just retrive the first row.
		$row = $queryResult->fetch_array(); 				
		$timexCategory->part = $row[4];
		$timexCategory->subPart = $row[5];
		$timexCategory->accessory = $row[3];						
	}
	clearStoredResults($timex_conn);
	return $timexCategory;

}

function getBrandItemCategory($timex_conn, $brandName, $brandCode){	
	$queryStr =  "CALL p_partCodeBrandSearch('". $brandName ."', '". $brandCode."', @res)";	
	$queryResult = $timex_conn->query($queryStr);
	$timexCategory = new TimexCategory();	
	$timexCategory->accessory = "unset";
	if ($queryResult && $queryResult->num_rows > 0){		
		//if timex return multiple row, then we just retrive the first row.
		$row = $queryResult->fetch_array() 				;
		$timexCategory->part = $row[1];
		$timexCategory->subPart = $row[2];
		$timexCategory->accessory = $row[0];						
	}
	clearStoredResults($timex_conn);
	return $timexCategory;
	

}

