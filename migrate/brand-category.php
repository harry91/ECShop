<?php
header ( "Content-type: text/html; charset=utf-8" );
require(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');

$accessoryBrandStr =  'CALL p_accessoriesBrand(@res)';	
$stmt = $timex_conn->prepare($accessoryBrandStr);			
$stmt->execute();
$stmt->bind_result($brand, $manufactories, $category);
while($stmt->fetch()) {			
	createBrand2Category($local_conn, $brand, $category);
}	
	
	
?>