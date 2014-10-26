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
	$stmt->bind_result($oemName, $oemAbbrivation, $oemBrand, $oemModel, $oemYear, $oemCapcity);		
	$subCatCount =0;
	while($stmt->fetch()) {						
		$subCatCount ++;
		if(!isExistCarType($local_conn, $carYearArr[$i]->yearId, $oemCapcity)) {							
			$maxCategoryId++;
			$carTypeId = $maxCategoryId;
			createCarYear($local_conn,$carTypeId, $oemCapcity,$carYearArr[$i]->yearId,0, 130, 'car-capacity');				
		}					
	}				
	echo 'there are '.$subCatCount.' capacity type  under '.$carYearArr[$i]->brandName.
		" \ ".$carYearArr[$i]->seriesName.
		" \ ".$carYearArr[$i]->yearName.'<br/>';
	$totalSubCategory = $totalSubCategory + $subCatCount;
	clearStoredResults($timex_conn);
	
}
echo 'there are number of '.$totalSubCategory.' car types <br/>';
?>