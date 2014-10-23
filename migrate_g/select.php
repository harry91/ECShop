<?php
require(dirname(__FILE__) . '/dbconfig.php');

$query =  'select * from ecs_admin_user';

$result=$local_conn->query($query);
if ($result) {
	if($result->num_rows>0){
		while($row =$result->fetch_array()){
			echo ('user id:' . $row[0])."<br>";
			echo ('user_name:' . $row[1])."<br>";
			echo "<hr>";
		}
	}
} else {
	echo "未返回结果";
}

?>