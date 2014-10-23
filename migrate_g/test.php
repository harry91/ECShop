<?php
header ( "Content-type: text/html; charset=utf-8" );

$timex_conn1 = new mysqli ("115.29.208.179", "sikubo", "Sikubo@2014!", "td_all");
$timex_conn1->set_charset ( "utf8" );
$series_ret = $timex_conn1->query ( "call p_searchBrand(@res)");
while ( $series_row = $series_ret->fetch_array () ) {
	echo "..." . $series_row[0] . "<br/>";
	
	$brands_ret = $timex_conn1->query ( "call p_searchBrand(@res)");
	while ( $brand_row = $brands_ret->fetch_array () ) {
		echo "......" . $brand_row[0] . "<br/>";
	}
}

?>
