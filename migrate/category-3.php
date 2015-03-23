<?php
header ( "Content-type: text/html; charset=utf-8" );

require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');
set_time_limit(0);

$category2Arr = getEcshopCategory2($local_conn);
$count = count($category2Arr);
$totalSubCategory = 0;
$maxCatId = getMaxCategoryId($local_conn);
for ($i = 0; $i < $count; $i++) {		
	$timexCategory3Str =  'CALL p_searchTKpsName(\''. $category2Arr[$i]->parentName .'\',\''. $category2Arr[$i]->categoryName .'\', @res)';		
	
	$stmt = $timex_conn->prepare($timexCategory3Str);			
	$stmt->execute();
	
	$subCatCount =0;
	while($stmt->fetch()) {		
		$subCatCount ++;
		$maxCatId++;
		createAccessory($local_conn, $category2Arr[$i]->categoryId, $timexAccessory, $maxCatId);
	}				
	echo 'there are total of '.$subCatCount.' accessory under part:'.$category2Arr[$i]->parentName
						.', subpart:'.$category2Arr[$i]->categoryName.'<br/>';
	$totalSubCategory = $totalSubCategory + $subCatCount;
	clearStoredResults($timex_conn);
}
echo 'there are number of '.$totalSubCategory.' accessories';

?>