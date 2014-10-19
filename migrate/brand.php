<?php
require(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');

$accessoryBrandStr =  'CALL p_accessoriesBrand(@res)';	
$maxBrandId = getMaxBrandId($local_conn);
echo 'bran id is '.$maxBrandId;
$stmt = $timex_conn->prepare($accessoryBrandStr);			
$stmt->execute();
$stmt->bind_result($brand, $manufactories, $category);
while($stmt->fetch()) {		
	echo 'brand: '.$brand ;	
	$maxBrandId++;
	createBrand($local_conn, $maxBrandId, $brand);
}
	
	
	
?>