<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


$carYearArr = getCarYears($local_conn);
$count = count($carYearArr);
$totalSubCategory = 0;
$maxCategoryId = getMaxCategoryId($local_conn);

for ($i = 0; $i < $count; $i++) {		
	$series =  "CALL p_searchCarEmissions('". $carYearArr[$i]->brandName.
			"','".$carYearArr[$i]->seriesName.
			"','".$carYearArr[$i]->yearName."',@res)";	
	$stmt = $timex_conn->prepare($series);			
	$stmt->execute();
	$stmt->bind_result($xid, $timerTypeName, $manufactoryBrandName,$manuafactoryName, $brandName,$tid,
		$timerTypeId, $timerModelId, $timeModelName, $year, $capacity );		
	$subCatCount =0;
	while($stmt->fetch()) {						
		$subCatCount ++;
		if(!isExistCarType($local_conn, $carYearArr[$i]->yearId, $capacity)) {							
			$maxCategoryId++;
			$carTypeId = $maxCategoryId;
			createCarYear($local_conn,$carTypeId, $capacity,$carYearArr[$i]->yearId,0, 130, 'car-capacity');				
		}					
	}				
	echo 'there are '.$subCatCount.' capacity type  under '.$carYearArr[$i]->brandName.
		" \ ".$carYearArr[$i]->seriesName.
		" \ ".$carYearArr[$i]->yearName.", id is: ".$carYearArr[$i]->yearId."<br/>";
	$totalSubCategory = $totalSubCategory + $subCatCount;
	clearStoredResults($timex_conn);
	
}
echo 'there are number of '.$totalSubCategory.' car types <br/>';
?>