<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once dirname(__FILE__) . '/Excel/reader.php';
require_once(dirname(__FILE__) . '/dbconfig.php');

// require(dirname(__FILE__) . '/../ecshop/includes/init.php');
// require_once(ROOT_PATH . '/../ecshop/' . ADMIN_PATH . '/includes/lib_goods.php');

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read('excel/goods-image-filenames.xls');
error_reporting(E_ALL ^ E_NOTICE);


$newLine='<br/>';

//$data->sheets[0]['numRows']
$i =0;
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
	
	$goodsImageName=$data->sheets[0]['cells'][$i][1];	
	$pointIndex = strripos($goodsImageName, ".");	
	$goodsId = substr($goodsImageName,0, $pointIndex);			
	$queryStr="update ecs_goods set goods_thumb='images/goods/".
	$goodsImageName."', goods_img = 'images/goods/".
	$goodsImageName."' where goods_id=".$goodsId;	

	echo $queryStr.'<br/>';	
 	$local_conn->query($queryStr);
 	
}

echo "total ".$i. " products are imported";


?>
