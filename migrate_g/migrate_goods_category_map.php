<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once (dirname ( __FILE__ ) . '/dbconfig.php');

$tmp_goods_cat_id = get_tmp_goods_cat_id();
echo "tmp_goods_cat_id: ".$tmp_goods_cat_id."<br/>";

$tmp_goods = $local_conn->query("select * from ecs_goods where cat_id=".$tmp_goods_cat_id);
if($tmp_goods && $tmp_goods->num_rows>0){
	while($tmp_goods_row = $tmp_goods->fetch_array()){
		$sql="call p_PartCodeBrandSearch('".$tmp_goods_row['brand_name']."', '".$tmp_goods_row['stock_code']."', @res)";
		$timex_conn2 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
		$timex_conn2->set_charset ( "utf8" );
		$cat_name = $timex_conn2->query($sql);
		if($cat_name && $cat_name->num_rows>0){
			$cat_name_row=$cat_name->fetch_array();
			$update_sql="update ecs_goods inner join (select cat_id from ecs_category where cat_name='".$cat_name_row['配件名称']."' and sort_order=70 limit 1) cat on ecs_goods.goods_id=".$tmp_goods_row['goods_id']." set ecs_goods.cat_id=cat.cat_id";
// 			echo $update_sql."<br/>";
			$local_conn->query($update_sql);
			echo $tmp_goods_row['goods_name'].": ".$cat_name_row['配件名称']."<br/>";
			$cat_name->free();
		}else{
			echo $tmp_goods_row['goods_name'].": no cat_name<br/>";
		}
		$timex_conn2->close();
	}
}

function get_tmp_goods_cat_id(){
	$local_conn = new mysqli ("localhost", "root", "sbsbsb", "testecs");
	$local_conn->set_charset ( "utf8" );
	$tmp_goods_cat=$local_conn->query("SELECT * FROM ecs_category WHERE cat_name='tmp_category' AND parent_id=0");
	$tmp_goods_cat_id='-1';
	if($tmp_goods_cat && $tmp_goods_cat->num_rows>0){
		$tmp_goods_cat_row=$tmp_goods_cat->fetch_array();
		$tmp_goods_cat_id=$tmp_goods_cat_row["cat_id"];
		$tmp_goods_cat->free();
	}
	return $tmp_goods_cat_id;
}
?>