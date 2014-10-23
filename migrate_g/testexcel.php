<?php
header ( "Content-type: text/html; charset=utf-8" );
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';

PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

if (!file_exists("./05featuredemo.xlsx")) {
	exit("Please run 05featuredemo.php first." . EOL);
}

echo date('H:i:s') , " Load from Excel2007 file" , EOL;
$callStartTime = microtime(true);

echo "a<br/>";
$objPHPExcel = PHPExcel_IOFactory::load("./05featuredemo.xlsx");
echo "b<br/>";
$arr = $objPHPExcel->getActiveSheet()->toArray();
echo "c<br/>";

for($i=0; $i<5; $i++){
	for($j=0; $j<5; $i++){
		echo $arr[$i][$j].", ";
	}
	echo "<br/>";
}

?>