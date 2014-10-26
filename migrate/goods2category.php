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
	//for ($i = 0; $i < 2; $i++) {		
		
		// excel 中,如果是原厂件,则brandName 是特殊的值 		
		if ($goodsArr[$i]->brandName == "原厂件"){
			$timexCategory = getOemItemCategory($timex_conn, $goodsArr[$i]->brandCode);
		} else {
			$timexCategory = getBrandItemCategory($timex_conn, $goodsArr[$i]->brandName, $goodsArr[$i]->brandCode);
		}
		if($timexCategory->accessory == "unset") {
			echo 'timex cannot find category for brand item: '. $goodsArr[$i]->brandCode.', and brand name is:'.$goodsArr[$i]->brandName.'<br/>' ;
			continue;
		}
		$accessoryId = getCatIdByAccessoryAndSubPart($local_conn, $timexCategory->subPart, $timexCategory->accessory);
		if($accessoryId == -1) {
			echo 'local database does not exist subpart '. $timexCategory->subPart.', and accessory:'.$timexCategory->accessory.'<br/>' ;
			continue;
		}
		
		updateCategory($local_conn, $goodsArr[$i]->goodsId, $accessoryId);
		
	}
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
		$timexCategory->accessory = $row[7];						
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

