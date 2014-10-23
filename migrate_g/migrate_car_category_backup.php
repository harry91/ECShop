<?php
$StartTime = time();

header ( "Content-type: text/html; charset=utf-8" );
require (dirname ( __FILE__ ) . '/dbconfig.php');

$timex_conn1 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
$timex_conn1->set_charset ( "utf8" );
$brands_ret = $timex_conn1->query ( "call p_searchBrand(@res)" );
// $timex_conn2=getNewTimexConn();

if ($brands_ret && $brands_ret->num_rows > 0) {
	// $insert_sql = "INSERT INTO ecs_category VALUES (?, ?, '车型分类', '', ?, ?, '', '', '1', '', '1', '0', '0')";
	echo "begin<br/>";
	while ( $brand_row = $brands_ret->fetch_array () ) {
		echo $brand_row [0] . "<br/><br/>";
		
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
				echo "..." . $series_row [0] . "<br/>";
				
				$timex_conn3 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
				$timex_conn3->set_charset ( "utf8" );
				// echo "call P_searchModelYear('".$brand_row[0]."' , '".$series_row[0]."' , @res)";
				$year_ret = $timex_conn3->query ( "call P_searchModelYear('" . $brand_row [0] . "' , '" . $series_row [0] . "' , @res)" );
				if (!($year_ret && $year_ret->num_rows > 0)) {
					echo "no result<br/>";
				} else {
					echo "......begin<br/>";
					while ( $year_row = $year_ret->fetch_array () ) {
						echo "......" . $year_row [0] . "<br/>";
						
						$timex_conn4 = new mysqli ( "115.29.208.179", "sikubo", "Sikubo@2014!", "td_all" );
						$timex_conn4->set_charset ( "utf8" );
// 						echo "call P_searchCarEmissions('" . $brand_row [0] . "' , '" . $series_row [0] . "' , '" . $year_row [0] . "' , @res)";
						$capacity = $timex_conn4->query ( "call P_searchCarEmissions('" . $brand_row [0] . "' , '" . $series_row [0] . "' , '" . $year_row [0] . "' , @res)" );
						if (!($capacity && $capacity->num_rows > 0)) {
							echo "no result<br/>";
						} else {
							echo ".........begin<br/>";
							while ( $capacity_row = $capacity->fetch_array () ) {
								echo "........." . $capacity_row [3] . "<br/>";
								
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
												echo "..............." . $variant_row [2] . "<br/>";
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
		// if ($series_ret && $series_ret->num_rows > 0) {
		// while($series_row = $series_ret->fetch_array() ){
		// echo $series_row[0]."<br/>";
		// }
		// }else{
		// echo $query_series;
		// echo "<br/>";
		// echo "call p_searchSeries('一汽大众' ,@res)";
		// echo "<br/>";
		// }
		echo "<br/><br/>";
	}
	echo "end<br/>";
	// $insert_sql = "INSERT INTO 'ecs_category'".
	// "('cat_name', 'timer_id', 'keywords', 'cat_desc', 'parent_id', 'sort_order', 'template_file', 'measure_unit', 'show_in_nav', 'style', 'is_show', 'grade', 'filter_attr' ) ".
	// "VALUES (?, '0', '', '', ?, '50', '', '', '0', '', '1', '0', '')";
}

echo "Time: ".(time()-$StartTime)."<br/>";
?>