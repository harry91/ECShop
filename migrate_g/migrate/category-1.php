<?php
header ( "Content-type: text/html; charset=utf-8" );
require(dirname(__FILE__) . '/dbconfig.php');

//get max category id
$result=$local_conn->query('select max(cat_id) from ecs_category');
$maxCategoryId = 1;
if ($result && $result->num_rows>0) {
	$row = $result-> fetch_array();
	if ($row) {
		echo "成功返回结果<br>";
		$maxCategoryId = $row[0];
		echo $maxCategoryId;
	}
}

$query =  "call p_searchAssemblyName(@res)";
$result = $timex_conn->query($query);
if ($result) {
	echo "成功返回结果<br/>";
	if($result->num_rows > 0){
		$newCategoryId = $maxCategoryId +1;
		$insert_sql = "INSERT INTO ecs_category ".
				" (cat_id, cat_name, keywords, cat_desc, parent_id, sort_order, template_file, measure_unit, show_in_nav, style)".
				" VALUES ".
				" (?,      ?,       'AccessoryType', '', ?,          ?,         '',            '',           '1',         '')";
		while($row = $result->fetch_array() ){

			$timex_category1_name = $row[0];
			$cat_id = $newCategoryId;
			$cat_name = $timex_category1_name;
			$cat_parent_id = 2;
			$order = 50;
			
			if ($stmt = $local_conn->prepare($insert_sql)) {
				$stmt->bind_param("isii", $cat_id, $cat_name, $cat_parent_id, $order);
				$stmt->execute();
				if($stmt->affected_rows >=1) {
					echo "迁移 [". $row[0] . "] 成功" . "<br/>";
					$newCategoryId++;
				}
			}
			else {
				printf("Errormessage: %s<br/>", $local_conn->error);
			}
		}
	}	
}else {
	echo "no result from timex";
}		
		
		
		

	
