<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once dirname(__FILE__) . '/Excel/reader.php';
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/ecshop_goods.php');
require_once(dirname(__FILE__) . '/db_release.php');


$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read('is_comm.xls');
error_reporting(E_ALL ^ E_NOTICE);

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {

	$goodsSn=$data->sheets[0]['cells'][$i][1];
	$isCommonForCar=$data->sheets[0]['cells'][$i][2];	
	echo 'is common for car'.$isCommonForCar;
	
	if(isExistGoodsBySn($local_conn, $goodsSn)){	
		updateGoodsIsCommon($local_conn, $goodsSn, $isCommonForCar );
	
	}else {
		echo "goods sn: ".$goodsSn." does not exist <br/>";
	}
	
}

echo "END<br/>";


?>
