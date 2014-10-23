<?php
$StartTime = time();
header ( "Content-type: text/html; charset=utf-8" );
require_once (dirname ( __FILE__ ) . '/dbconfig.php');

$tmp_goods = $local_conn->query("select * from ecs_goods");
if($tmp_goods && $tmp_goods->num_rows>0){
	while($tmp_goods_row = $tmp_goods->fetch_array()){
		$sql="call p_searchTidByKpsCodeDealer('".$tmp_goods_row['stock_code']."', @res)";
		$timex_conn2 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
		$timex_conn2->set_charset ( "utf8" );
		$car_name = $timex_conn2->query($sql);
		if($car_name && $car_name->num_rows>0){
			$car_name_row=$car_name->fetch_array();
			$cat_id=$local_conn->query("select cat_id from ecs_category where cat_name = '".$car_name_row['TMODELNAME']."'");
			if($cat_id && $cat_id->num_rows>0){
				$cat_id_row=$cat_id->fetch_array();
				$insert_sql="INSERT INTO ecs_goods_cat (goods_id, cat_id) values ('".$tmp_goods_row['goods_id']."' ,".$cat_id_row[0].")";
// 				echo $insert_sql."<br/>";
// 				return;
				$local_conn->query($insert_sql);
				$cat_id->free();
				echo $tmp_goods_row['goods_name'].": ".$car_name_row['TMODELNAME']."<br/>";
			}else{
				echo $tmp_goods_row['goods_name'].": no car_name in local<br/>";
			}
			$car_name->free();
		}else{
			echo $tmp_goods_row['goods_name'].": no car_name on remote<br/>";
		}
		$timex_conn2->close();
	}
}
echo "Time: ".(time()-$StartTime)."<br/>";
echo "END<br/>"
?>