<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


$carBrandArr = getCarBrand($local_conn);
$count = count($carBrandArr);
$totalCount = 0;
for ($i = 0; $i < $count; $i++) {		
	$series =  'CALL p_searchSeries(\''. $carBrandArr[$i]->brandName .'\', @res)';		
	$stmt = $timex_conn->prepare($series);			
	$stmt->execute();
	$stmt->bind_result($carSeriesName);
	$subCount =0;
	while($stmt->fetch()) {				
		$subCount++;
		// timer id is 0 because timer doesn't set id for car brand
		// sort order is set to 100, car2 sort order will be 110, car3 will be 120,...
		// keywords	: car-brand, car-series, car-year, car-type, car-model
		createCar($local_conn, $carSeriesName, $carBrandArr[$i]->brandId,0, 110, 'car-series');					
	}	
	echo 'there are '.$subCount.' series under '.$carBrandArr[$i]->brandName.'<br/>';	
	clearStoredResults($timex_conn);
	$totalCount =$totalCount +$subCount;
}
echo 'there are total '.$totalCount.' series'.'<br/>';	
?>