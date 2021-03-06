<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once dirname(__FILE__) . '/Excel/reader.php';
require_once(dirname(__FILE__) . '/dbconfig.php');

// require(dirname(__FILE__) . '/../ecshop/includes/init.php');
// require_once(ROOT_PATH . '/../ecshop/' . ADMIN_PATH . '/includes/lib_goods.php');

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read('excel/20141103V9.xls');
error_reporting(E_ALL ^ E_NOTICE);



$tmp_goods_cat_id=get_tmp_goods_cat_id();
$i =0;
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
	
	$goods_sn=$data->sheets[0]['cells'][$i][3];
	$provider_name=$data->sheets[0]['cells'][$i][1];
	$goods_name=$data->sheets[0]['cells'][$i][4];
	$stock_code=$data->sheets[0]['cells'][$i][5];
	$shop_price=$data->sheets[0]['cells'][$i][6];
	$brand_name=$data->sheets[0]['cells'][$i][2];
	$unit_name=$data->sheets[0]['cells'][$i][8];
	$goods_number=$data->sheets[0]['cells'][$i][7];
	$goods_id = $goods_sn;

	
	$exists_goods=$local_conn->query("SELECT * FROM ecs_goods where goods_sn = '$goods_sn'");
	if($exists_goods && $exists_goods->num_rows>0){
		$exists_goods->free();
		echo "goods_sn='$goods_sn' exists<br/>";
		continue;
	}
	
	// the number is not migrated since it may block importing if it is empty.
	
	$insert_query="INSERT INTO ecs_goods".
	" (goods_id, goods_sn,  provider_name,  goods_name,  stock_code,  shop_price,  brand_name,  unit_name, unit_format, goods_number, cat_id, ".
	"keywords, goods_brief, goods_desc, goods_thumb, goods_img, original_img, extension_code, seller_note )".
	"VALUES".
	" ($goods_id, '$goods_sn','$provider_name','$goods_name','$stock_code','$shop_price','$brand_name','$unit_name','$unit_format',0,'$tmp_goods_cat_id',".
	"'', '', '', '', '', '', '', '' )";
	
 	$local_conn->query($insert_query);
 	
}

echo "total ".$i. " products are imported";

function get_tmp_goods_cat_id(){		
	return 1;
}

// function get_goods_sn(){
// 	$max_id     = $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods'));
// 	$goods_sn   = generate_goods_sn($max_id);
// 	return $goods_sn;
// }
?>
