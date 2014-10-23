<?php
//local ecshop databse
$local_conn = new mysqli("localhost", "root", "sbsbsb", "testecs");
if (!$local_conn)
{
	die('Could not connect local database.');
}
$local_conn->set_charset("utf8");

//remote timex database
$timex_conn = new mysqli("115.29.208.179", "sikubo", "Sikubo@2014!", "td_all");
if (!$timex_conn)
{
	die('Could not connect timex database.');
}
$timex_conn->set_charset("utf8");
?>