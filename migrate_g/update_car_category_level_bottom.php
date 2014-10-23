<?php
$StartTime = time();

header ( "Content-type: text/html; charset=utf-8" );
require (dirname ( __FILE__ ) . '/dbconfig.php');

$timex_conn1 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
$timex_conn1->set_charset ( "utf8" );
$brands_ret = $timex_conn1->query ( "call p_searchBrand(@res)" );

$local_conn1 = new mysqli ( "localhost", "root", "sbsbsb", "testecs" );
$local_conn1->set_charset ( "utf8" );
$car_brand_root = $local_conn1->query("select * from ecs_category where cat_name='车型' and parent_id=0 and cat_id=1");
if(! ($car_brand_root && $car_brand_root->num_rows > 0) ){
	echo "error<br/>";
	return;
}
$car_brand_root->free();
$local_conn1->close();

if ($brands_ret && $brands_ret->num_rows > 0) {
	echo "begin<br/>";
	
	while ( $brand_row = $brands_ret->fetch_array () ) {
		echo $brand_row[0] . "<br/><br/>";
		
		$curr_car_brand_id = insertCarCategory($brand_row[0], '1', "brand");
		
		$timex_conn2 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
		$timex_conn2->set_charset ( "utf8" );
		$series_ret = $timex_conn2->query ( "call p_searchSeries('" . $brand_row [0] . "' ,@res)" );
		if (! $series_ret) {
			echo "error result<br/>";
		} else if ($series_ret->num_rows <= 0) {
			echo "no result<br/>";
		} else {
			echo "...begin<br/>";
			while ( $series_row = $series_ret->fetch_array () ) {
				echo "..." . $series_row[0] . "<br/>";
				
				$curr_car_series_id = insertCarCategory($series_row[0], $curr_car_brand_id, "series");
				$curr_car_null_type_id = insertCarCategory("null_type", $curr_car_series_id, "null_type");
				
				$timex_conn3 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
				$timex_conn3->set_charset ( "utf8" );
				$year_ret = $timex_conn3->query ( "call P_searchModelYear('" . $brand_row [0] . "' , '" . $series_row [0] . "' , @res)" );
				if (!($year_ret && $year_ret->num_rows > 0)) {
					echo "no result<br/>";
				} else {
					echo "......begin<br/>";
					while ( $year_row = $year_ret->fetch_array () ) {
						echo "......" . $year_row[0] . "<br/>";
						$curr_car_year_id = insertCarCategory($year_row[0], $curr_car_null_type_id, "year");
						
						$timex_conn4 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
						$timex_conn4->set_charset ( "utf8" );
						$capacity = $timex_conn4->query ( "call P_searchCarEmissions('" . $brand_row [0] . "' , '" . $series_row [0] . "' , '" . $year_row [0] . "' , @res)" );
						if (!($capacity && $capacity->num_rows > 0)) {
							echo "no result<br/>";
						} else {
							echo ".........begin<br/>";
							while ( $capacity_row = $capacity->fetch_array () ) {
								echo "........." . $capacity_row[3] . "<br/>";
								$curr_car_capacity_id = insertCarCategory($capacity_row[3], $curr_car_year_id, "capacity");
								
								$timex_conn5 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
								$timex_conn5->set_charset ( "utf8" );
								$model = $timex_conn5->query ( "call P_searchEmissionsModel('" . $brand_row [0] . "' , '" . $series_row [0] . "' , '" . $year_row [0] . "' , '" . $capacity_row[3] . "' , @res)" );
								if (!($model && $model->num_rows > 0)) {
									echo "no result<br/>";
								} else {
									echo "............begin<br/>";
									while ( $model_row = $model->fetch_array () ) {
										echo "............" . $model_row [4] . "<br/>";
										
										$timex_conn6 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
										$timex_conn6->set_charset ( "utf8" );
										$variant = $timex_conn6->query ( "call P_searchVariantName('" . $brand_row [0] . "' , '" . $series_row [0] . "' , '" . $year_row [0] . "' , '" . $model_row[4] . "' , @res)" );
										if (!($variant && $variant->num_rows > 0)) {
											echo "no result<br/>";
										} else {
											echo "...............begin<br/>";
											while ( $variant_row = $variant->fetch_array () ) {
												echo "..............." . $variant_row[2] . "<br/>";
												updateCarCategory($variant_row[2], $curr_car_capacity_id, "variant");
											}
											echo "...............end<br/>";
										}
										$variant->free();
										$timex_conn6->close();
									}
									echo "............end<br/>";
								}
								$model->free();
								$timex_conn5->close();
							}
							echo ".........end<br/>";
						}
						$capacity->free ();
						$timex_conn4->close ();
					}
					echo "......end<br/>";
				}
				$year_ret->free ();
				$timex_conn3->close ();
			}
			echo "...end<br/>";
			echo "Time: ".(time()-$StartTime)."<br/>";
		}
		
		$series_ret->free ();
		$timex_conn2->close ();
		echo "<br/><br/>";
	}
	echo "end<br/>";
}

function insertCarCategory($cat_name, $parent_id, $cat_symbol = "category"){
	$local_conn1 = new mysqli ( "localhost", "root", "sbsbsb", "testecs" );
	$local_conn1->set_charset ( "utf8" );
	$local_car_cat = $local_conn1->query("select * from ecs_category where cat_name='".$cat_name."' and parent_id=".$parent_id);
	$curr_car_cat_id='-1';
	if(!($local_car_cat && $local_car_cat->num_rows>0)){
		$local_conn1_1 = new mysqli ( "localhost", "root", "sbsbsb", "testecs" );
		$local_conn1_1->set_charset ( "utf8" );
		$local_conn1_1->query("INSERT INTO ecs_category".
				" (cat_name, parent_id, timer_id, keywords, cat_desc, sort_order, template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr ) ".
				"VALUES  ('".$cat_name."', '".$parent_id."', '0', '', '', '50', '', '', '0', '', '1', '0', '')");
		$curr_car_cat_id = $local_conn1_1->insert_id;
		$local_conn1_1->close();
		echo "new car ".$cat_symbol." inserted: ".$cat_name." ".$curr_car_cat_id."<br/>";
	}else{
		$local_car_cat_row=$local_car_cat->fetch_array();
		$curr_car_cat_id=$local_car_cat_row["cat_id"];
		$local_car_cat->free();
		echo "original car ".$cat_symbol." found: ".$cat_name." ".$curr_car_cat_id."<br/>";
	}
	$local_conn1->close();
	return $curr_car_cat_id;
}

function updateCarCategory($cat_name, $parent_id, $cat_symbol = "category"){
	$local_conn1 = new mysqli ( "localhost", "root", "sbsbsb", "testecs" );
	$local_conn1->set_charset ( "utf8" );
	$local_conn1->query("UPDATE ecs_category SET sort_order = 65 where cat_name='".$cat_name."' and parent_id=".$parent_id);
	$local_conn1->close();
	return $curr_car_cat_id;
}

echo "Time: ".(time()-$StartTime)."<br/>";
?>
