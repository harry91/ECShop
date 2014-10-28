<?php
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


$category1Arr = getEcshopCategory1($local_conn);
$count = count($category1Arr);
$totalSubCategory = 0;
for ($i = 0; $i < $count; $i++) {		
	$timexCategory2Str =  'CALL p_searchSubAssemblyName(\''. $category1Arr[$i]->categoryName .'\', @res)';		
	$stmt = $timex_conn->prepare($timexCategory2Str);			
	$stmt->execute();
	$stmt->bind_result($timexCategoryName, $timxsubCategoryName);
	$subCatCount =0;
	while($stmt->fetch()) {		
		$subCatCount ++;
		createCategory2($local_conn, $category1Arr[$i]->categoryId, $timxsubCategoryName);
	}				
	echo 'there are '.$subCatCount.' under '.$category1Arr[$i]->categoryName.'<br/>';
	$totalSubCategory = $totalSubCategory + $subCatCount;
	clearStoredResults($timex_conn);
	
}
echo 'there are number of '.$totalSubCategory.' sub categories';
?>