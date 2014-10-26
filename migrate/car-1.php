<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


$query =  "call p_searchBrand(@res)";
$result = $timex_conn->query($query);
$totalBrands = 0;
if ($result) {
	echo "成功返回结果<br/>";
	if($result->num_rows > 0){				
		while($row = $result->fetch_array() ){
			$totalBrands++;
			$timex_category1_name = $row[0];
			// the first car parent is pre-set as 1
			// timer id is 0 because timer doesn't set id for car brand
			// sort order is set to 100, car2 sort order will be 110, car3 will be 120,...
			// keywords	: car-brand, car-series, car-year, car-type, car-model
			createCar($local_conn, $timex_category1_name, 1,0, 100, 'car-brand');
		}
	}	
}else {
	echo "no result from timex";
}		
echo 'total brands: '.$totalBrands;
		
		
		

	
