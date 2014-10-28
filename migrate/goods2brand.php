	<?php
$StartTime = time();

header ( "Content-type: text/html; charset=utf-8" );
require (dirname ( __FILE__ ) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');
require_once (dirname ( __FILE__ ) . '/ecshop_goods.php');

resetGoodsBrand($local_conn);
function resetGoodsBrand($local_conn){
	$goodsArr = getBrandIsNullGoods($local_conn);
	$goodsCount = count($goodsArr);
	for ($i = 0; $i < $goodsCount; $i++) {	
	//for ($i = 0; $i < 2; $i++) {		
		
		// excel 中,如果是原厂件,则brandName 是特殊的值 		
		$brandId = getBrandId($local_conn, $goodsArr[$i]->brandName);		
		if($brandId == 0) {
			echo 'brand name: '.$goodsArr[$i]->brandName.' does not exist in db, please migrate brand first<br/>' ;
			continue;
		}						
		updateGoodsBrand($local_conn, $goodsArr[$i]->goodsId, $brandId);		
	}
}

