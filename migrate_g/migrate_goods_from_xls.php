<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once dirname(__FILE__) . '/Excel/reader.php';

// require(dirname(__FILE__) . '/../ecshop/includes/init.php');
// require_once(ROOT_PATH . '/../ecshop/' . ADMIN_PATH . '/includes/lib_goods.php');

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read('test03.xls');
error_reporting(E_ALL ^ E_NOTICE);

//echo $data->sheets[0]['numRows'].", ".$data->sheets[0]['numCols']."<br/>";
$local_conn = new mysqli ("localhost", "root", "sbsbsb", "testecs");
$local_conn->set_charset ( "utf8" );

$tmp_goods_cat_id=get_tmp_goods_cat_id();

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {

	$goods_sn=$data->sheets[0]['cells'][$i][1];
	$provider_name=$data->sheets[0]['cells'][$i][2];
	$goods_name=$data->sheets[0]['cells'][$i][3];
	$stock_code=$data->sheets[0]['cells'][$i][4];
	$shop_price=$data->sheets[0]['cells'][$i][5];
	$brand_name=$data->sheets[0]['cells'][$i][6];
	$unit_name=$data->sheets[0]['cells'][$i][7];
	$goods_number=$data->sheets[0]['cells'][$i][8];
	
// 	$delete_query="DELETE FROM ecs_goods where goods_sn='$goods_sn'";
// 	$local_conn->query($delete_query);
	
	$exists_goods=$local_conn->query("SELECT * FROM ecs_goods where goods_sn = '$goods_sn'");
	if($exists_goods && $exists_goods->num_rows>0){
		$exists_goods->free();
		echo "goods_sn='$goods_sn' exists<br/>";
		continue;
	}
	
	$insert_query="INSERT INTO ecs_goods".
	" (goods_sn,  provider_name,  goods_name,  stock_code,  shop_price,  brand_name,  unit_name, unit_format, goods_number, cat_id, ".
	"keywords, goods_brief, goods_desc, goods_thumb, goods_img, original_img, extension_code, seller_note )".
	"VALUES".
	" ('$goods_sn','$provider_name','$goods_name','$stock_code','$shop_price','$brand_name','$unit_name','$unit_format','$goods_number','$tmp_goods_cat_id',".
	"'', '', '', '', '', '', '', '' )";
	
 	$local_conn->query($insert_query);
 	
	//echo $insert_query."<br/>";
	
	echo "goods_sn='$goods_sn' inserted<br/>";
}

echo "END<br/>";

function get_tmp_goods_cat_id(){
	$local_conn = new mysqli ("localhost", "root", "sbsbsb", "testecs");
	$local_conn->set_charset ( "utf8" );
	$tmp_goods_cat=$local_conn->query("SELECT * FROM ecs_category WHERE cat_name='tmp_category' AND parent_id=0");
	$tmp_goods_cat_id='-1';
	if(!($tmp_goods_cat && $tmp_goods_cat->num_rows>0)){
		$local_conn2 = new mysqli ( "localhost", "root", "sbsbsb", "testecs" );
		$local_conn2->set_charset ( "utf8" );
		$local_conn2->query("INSERT INTO ecs_category".
				" (cat_name, parent_id, timer_id, keywords, cat_desc, sort_order, template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr ) ".
				"VALUES  ('tmp_category', '0', '0', '', '', '50', '', '', '0', '', '1', '0', '')");
		$tmp_goods_cat_id = $local_conn2->insert_id;
		$local_conn2->close();
	}else{
		$tmp_goods_cat_row=$tmp_goods_cat->fetch_array();
		$tmp_goods_cat_id=$tmp_goods_cat_row["cat_id"];
		$tmp_goods_cat->free();
	}
	$local_conn->close();
	return $tmp_goods_cat_id;
}

// function get_goods_sn(){
// 	$max_id     = $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods'));
// 	$goods_sn   = generate_goods_sn($max_id);
// 	return $goods_sn;
// }
?>
