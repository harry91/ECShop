<?php
require(dirname(__FILE__) . '/dbconfig.php');

//test insert
$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, '', '', ?, ?, '', '', '1', '', '1', '0', '0')";

   $stmt = $local_conn->prepare($insert_sql);
   /* i 	 integer
	d 	 double
	s 	 string
	b 	corresponding variable is a blob and will be sent in packets
    * */
   $stmt -> bind_param('isii', $cat_id, $cat_name, $cat_parent_id, $order);  
   $cat_id = 1;  
   $cat_name = '一汽大众';  
   $cat_parent_id = 0;
   $order = 50;
   $stmt->execute();
     
   echo '修改了'.$stmt->affected_rows.'行';  


?>