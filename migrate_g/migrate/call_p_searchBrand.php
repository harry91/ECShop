<?php
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

//start migration
$query =  "call p_searchBrand(@res)";

$result = $timex_conn->query($query);
if ($result) {
	echo "成功返回结果<br/>";
	if($result->num_rows > 0){
		$i = $maxCategoryId + 1;
		$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, '车型分类', '', ?, ?, '', '', '1', '', '1', '0', '0')";
		while($row = $result->fetch_array() ){
			$timex_brand_name = $row[0];
	   
			$stmt = $local_conn->prepare($insert_sql);
			$stmt->bind_param("isii", $cat_id, $cat_name, $cat_parent_id, $order);
			$cat_id = $i;
			$cat_name = $timex_brand_name;
			$cat_parent_id = 0;
			$order = 50;
			$stmt->execute();
			if ($stmt->affected_rows >= 1){
				echo "迁移 [". $row[0] . "] 成功" . "<br/>";
				$i++;
			}
		}
	}
}else {
	echo "未返回结果";
}
