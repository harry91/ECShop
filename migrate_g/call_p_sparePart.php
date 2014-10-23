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

$query =  "call p_SparePart(@res)";

$result = $timex_conn->query($query);
if ($result) {
	echo "成功返回结果<br/>";
	if($result->num_rows > 0){
		$i = $maxCategoryId + 1;
		$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, '配件分类', '', ?, ?, '', '', '1', '', '1', '0', '0')";
		$parts_cat_array = array();
		while($row = $result->fetch_array() ){
			$timex_parts_cat_1 = $row[0];
			if (in_array($timex_parts_cat_1, $parts_cat_array)) {
				continue;
			}
			
			$parts_cat_array[$i - 1] = $timex_parts_cat_1;
	   
			$stmt = $local_conn->prepare($insert_sql);
			$stmt->bind_param("isii", $cat_id, $cat_name, $cat_parent_id, $order);
			$cat_id = $i;
			$cat_name = $timex_parts_cat_1;
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
