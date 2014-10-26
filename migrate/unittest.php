<?php
$a = "a";
$b = "b,2',";

$len =strlen($b);
echo $len;

$a = substr($b, 0, $len-2 );
echo $a;


?>