<?php
require_once(dirname(__FILE__) . '/dbconfig.php');
require_once(dirname(__FILE__) . '/db_release.php');
require_once(dirname(__FILE__) . '/ecshop_category.php');

$ret = isExistBrand($local_conn, '配件品牌A');
if($ret) {
 echo 'exist';
} else {
  echo 'not exist';
}
?>