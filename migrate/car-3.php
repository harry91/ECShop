<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


$carSeriesArr = getCarSeries($local_conn);
$count = count($carSeriesArr);
$totalSubCategory = 0;
$maxCategoryId = getMaxCategoryId($local_conn);

for ($i = 0; $i < $count; $i++) {		
	$series =  "CALL p_searchModelYear('". $carSeriesArr[$i]->brandName.
			"','".$carSeriesArr[$i]->seriesName."',  @res)";	
	$stmt = $timex_conn->prepare($series);			
	$stmt->execute();
	$stmt->bind_result($year);
		
	$subCatCount =0;
	while($stmt->fetch()) {				
		// timer id is 0 because timer doesn't set id for car brand
		// sort order is set to 100, car2 sort order will be 110, car3 will be 120,...
		// keywords	: car-brand, car-series, car-year, car-type, car-model
		$subCatCount ++;
		if(!isExistCarYear($local_conn, $carSeriesArr[$i]->seriesId, $year)){						
			$maxCategoryId++;
			$carYearId = $maxCategoryId;
			createCarYear($local_conn,$carYearId, $year, $carSeriesArr[$i]->seriesId,0, 120, 'car-year');				
		}
		
	}				
	echo 'there are car year'.$subCatCount.' under '.$carSeriesArr[$i]->brandName." \ ".$carSeriesArr[$i]->seriesName.'<br/>';
	$totalSubCategory = $totalSubCategory + $subCatCount;
	clearStoredResults($timex_conn);
	
}
echo 'there are number of '.$totalSubCategory.' car years <br/>';
?>