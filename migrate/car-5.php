<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


$carSeriesArr = getCarSeries($local_conn);
$count = count($carSeriesArr);
$totalSubCategory = 0;


for ($i = 1; $i < $count; $i++) {		
	$series =  "CALL p_searchModels('". $carSeriesArr[$i]->brandName.
			"','".$carSeriesArr[$i]->seriesName."',  @res)";	
	$stmt = $timex_conn->prepare($series);			
	$stmt->execute();
	$stmt->bind_result($variantName, $tid, $xid, $timerModelId,$timerTypeId, $timerModelName,$timerTypeName,
	        $manufactory, $brandName, $series, $subSeries, $seriesYear,	$modelStartYear, $modelEndYear, $typeStartYear, $typeEndYear, 
				$egine, $outputVolumeML, $outputVolumL, $power, $transmissionType, $driveType);
		
	$subCatCount =0;
	
	try {
		$local_conn->autocommit(FALSE);
		while($stmt->fetch()) {		
			$subCatCount ++;
			// timer id is 0 because timer doesn't set id for car brand
			// sort order is set to 100, car2 sort order will be 110, car3 will be 120,...
			// keywords	: car-brand, car-series, car-year, car-type, car-model	
				
			$carYearId = getCarYearId($local_conn, $carSeriesArr[$i]->seriesId, $seriesYear);	
			
			
			$carTypeId = getCarTypeId($local_conn, $carYearId, $outputVolumL);					
			
			
			createCarModel($local_conn, $timerModelName, $carTypeId,$tid, 140, 'car-model');				
		}	
		$local_conn->commit();
	}catch (Exception $e) {
		echo 'failed: '. $e->getMessage();
		$local_conn->rollBack();
	}	
	
	echo 'there are '.$subCatCount.' under '.$carSeriesArr[$i]->brandName." \ ".$carSeriesArr[$i]->seriesName.'<br/>';
	$totalSubCategory = $totalSubCategory + $subCatCount;
	clearStoredResults($timex_conn);
	
}
echo 'there are number of '.$totalSubCategory.' car models <br/>';
?>
