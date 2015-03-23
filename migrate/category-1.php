<?php
header ( "Content-type: text/html; charset=utf-8" );
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');


migrateCategory1($timex_conn, $local_conn);

function migrateCategory1($timex_conn, $local_conn) {
	$maxCategoryId = getMaxCategoryId($local_conn);
	$query =  "call p_searchAssemblyName(@res)";
	$result = $timex_conn->query($query);
	$count = 1;
	if ($result) {	
		if($result->num_rows > 0){
	    
			$newCategoryId = $maxCategoryId +1;
			$insert_sql = "INSERT INTO ecs_category VALUES (?, ?,0, '配件分类', '', ?, ?, '', '', '1', '', '1', '0', '0')";
			while($row = $result->fetch_array()){
				$count = $count +1;			
				$timex_category1_name = $row[0];
				if (isExistCategory1($local_conn, $timex_category1_name)){
					echo 'category: '.$timex_category1_name.' exist, will be ignored'.'<br/>';
					continue;
				}
				
					
				$stmt = $local_conn->prepare($insert_sql);
				$stmt->bind_param("isii", $cat_id, $cat_name, $cat_parent_id, $order);
				$cat_id = $newCategoryId;
				$cat_name = $timex_category1_name;
				$cat_parent_id = 2;
				$order = 50;
				$stmt->execute();
				if($stmt->affected_rows >=1) {					
					$newCategoryId++;
				}
			}
		}	
	echo 'total count:'.$count."<br/>";
	}else {
	echo "no result from timex";
	}		
		
}		
		

	
