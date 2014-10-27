<?php

class Category1 {
	public  $categoryId;
	public  $categoryName;		
}

class Category2 {
	public  $categoryId;
	public  $categoryName;		
	public  $parentName;
}

Class CarBrand {
	public $brandId;
	public $brandName;
}

Class CarSeries {	
	public $seriesId;
	public $seriesName;
	public $brandId;
	public $brandName;
}

Class CarYear {	
	public $yearId;
	public $yearName;
	public $seriesId;
	public $seriesName;
	public $brandId;
	public $brandName;
}

Class CarModelType {	
	public $carModelTypeId;
	public $carModelTypeName;
	public $yearId;
	public $yearName;
	public $seriesId;
	public $seriesName;
	public $brandId;
	public $brandName;
}



function getMaxCategoryId($mysqli_link) {
	$result=$mysqli_link->query('select max(cat_id) from ecs_category');
	$maxCategoryId = 1;
	if ($result && $result->num_rows>0) {
		$row = $result-> fetch_array();
		if ($row) {			
			$maxCategoryId = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	return $maxCategoryId;
}


/*
	得到所有总成
*/
function getEcshopCategory1($mysqli_link) {
	$selectCategory1Str =  "select cat_id, cat_name from ecs_category  where parent_id = 2 and show_in_nav=1";
	$category1Result = $mysqli_link->query($selectCategory1Str);

	if ($category1Result && $category1Result->num_rows > 0){
		$index = 0;
		while($category1Row = $category1Result->fetch_array() ){
			$category1 = new Category1();		
			$category1->categoryId = $category1Row[0];
			$category1->categoryName = $category1Row[1];
			$category1Arr[$index] =$category1;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $category1Arr;
}

/*
	得到所有 分总成
*/
function getEcshopCategory2($mysqli_link) {
	$selectCategory2Str =  "SELECT c2.cat_id as cat_id, c2.cat_name as cat_name, c1.cat_name as parent_name FROM ecs_category as c2 inner join ecs_category as c1  on c2.parent_id = c1.cat_id where c2.show_in_nav=2;";
	
	$category1Result = $mysqli_link->query($selectCategory2Str);

	if ($category1Result && $category1Result->num_rows > 0){
		$index = 0;
		while($category1Row = $category1Result->fetch_array() ){
			$category2 = new Category2();		
			$category2->categoryId = $category1Row[0];
			$category2->categoryName = $category1Row[1];
			$category2->parentName = $category1Row[2];
			$category2Arr[$index] =$category2;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $category2Arr;
}

function createCategory2($mysqli_link, $category, $subCategory){
	if(isExistCategory2($mysqli_link,$subCategory)){
		echo $subCategory.'已经存在';
		return;
	}
	$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, 0, '配件分类', '', ?, 60, '', '', '2', '', '1', '0', '0')";
	$stmt = $mysqli_link->prepare($insert_sql);
	$stmt->bind_param('isi',$cat_id, $cat_name, $cat_parent_id );
	$currentCategoryId = getMaxCategoryId($mysqli_link) +1;
	$cat_id = $currentCategoryId;
	$cat_name = $subCategory;
	$cat_parent_id = getCategory1Id($mysqli_link, $category);
	if($cat_parent_id == 0) {
		echo "the parent category doesn't exist for category ".$subCategory;
	}
	$stmt->execute();
	clearStoredResults($mysqli_link);		
}

/*
创建配件 
*/
function createAccessory($mysqli_link, $parentId, $timexAccessory,$new_cat_id) {
	if(ifExistAccessory($mysqli_link,$parentId, $timexAccessory)){
		echo $subCategory.'已经存在';
		return;
	}
	$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, 0, '配件分类', '', ?, 70, '', '', '3', '', '1', '0', '0')";
	$stmt = $mysqli_link->prepare($insert_sql);
	$stmt->bind_param('isi',$cat_id, $cat_name, $cat_parent_id );
	$currentCategoryId = $new_cat_id;
	$cat_id = $currentCategoryId;
	$cat_name = $timexAccessory;
	$cat_parent_id = $parentId;	
	$stmt->execute();
	clearStoredResults($mysqli_link);
}

/*
	配件是否存在
*/
function ifExistAccessory($mysqli_link, $parentId, $timexAccessory) {
	$query_str = 'select count(*) from ecs_category where cat_name=\''.$timexAccessory.'\' and show_in_nav=3 and parent_id='.$parentId;		
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}	
	return $ret;
}


function getCategory1Id($mysqli_link, $category1Name) {
	$query_str = 'select cat_id from ecs_category where cat_name=\''.$category1Name.'\' and show_in_nav=1';		
	$result = $mysqli_link->query($query_str);
	$ret = 0;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$ret = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}

function isExistCategory1($mysqli_link, $category1Name) {
	$query_str = 'select count(*) from ecs_category where cat_name=\''.$category1Name.'\' and show_in_nav=1';		
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}	
	return $ret;
}

function isExistCategory2($mysqli_link, $category2Name) {
	$query_str = 'select count(*) from ecs_category where cat_name=\''.$category2Name.'\' and show_in_nav=2';	
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}
	
	return $ret;
}


function isExistCategory3($mysqli_link, $category1Name) {
	$query_str = 'select count(*) from ecs_category where cat_name=\''.$category1Name.'\' and show_in_nav=3';	
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}	
	return $ret;
}
/*
	生成brand
*/
function createBrand($mysqli_link,  $brandName) {    
	
	if(isExistBrand($mysqli_link,$brandName)){
		echo $brandName.'已经存在';
		return;
	}
	$insert_sql = "INSERT INTO ecs_brand ( brand_name, brand_desc)VALUES ( ?, ?)";
	echo $insert_sql;
	$stmt = $mysqli_link->prepare($insert_sql);
	$stmt->bind_param('ss',$brandName, $brandDesc);		
	$brandDesc = $brandName;
	$stmt->execute();	
	clearStoredResults($mysqli_link);
}

/*
	check brand existing
*/
function isExistBrand($mysqli_link,$brandName){
	$query_str = 'select count(*) from ecs_brand where brand_name=\''.$brandName.'\'';	
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}	
	return $ret;
}
/*
  return max brand Id to generate new brand id
*/
function getMaxBrandId($mysqli_link) {
	$maxBrandId = 1;
	$result=$mysqli_link->query('select max(brand_id) from ecs_brand');	
	if ($result && $result->num_rows>0) {
		$row = $result-> fetch_array();
		if ($row) {			
			$maxBrandId = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	echo 'max brand id is '.$maxBrandId;
	return $maxBrandId;
}

/*
*/
function getBrandId($mysqli_link, $brandName) {
	$brandId = 0;
	$queryStr = "select brand_id from ecs_brand where brand_name = '".$brandName."'";
	echo $queryStr."<br/>";
	$result=$mysqli_link->query($queryStr);		
	if ($result && $result->num_rows>0) {
		$row = $result-> fetch_array();			
		$brandId = $row[0];						
	}
	clearStoredResults($mysqli_link);	
	return $brandId;
}

function createBrand2Category($mysqli_link, $brandName, $categoryName) {
	$categoryId = getCategory1Id($mysqli_link, $categoryName);
	if ($categoryId ==0) {
		echo 'part: '.$categoryName.'does not exist, please migrate part first<br/>';
		return;
	}
	
	$brandId = getBrandId($mysqli_link, $brandName);
	if ($brandId == 0) {
		echo 'brand: '.$brandName .'does not exist, please migrate brand first<br/>';
		return;
	}
	if(isExistBrand2Category($mysqli_link,$brandId, $categoryId)){		
		return;
	}
	
	$insert_sql = "INSERT INTO ecs_brand2Category ( brand_id, cat_id)VALUES ( ?, ?)";
	$stmt = $mysqli_link->prepare($insert_sql);
	$stmt->bind_param('ii',$brandId, $categoryId);		
	$stmt->execute();	
	clearStoredResults($mysqli_link);	
}

/*
*/
function isExistBrand2Category($mysqli_link,$brandId, $categoryId){
	$query_str = 'select count(*) from ecs_brand2category where brand_id='.$brandId.' and cat_id = '.$categoryId;	
	$result = $mysqli_link->query($query_str);
	$ret = false;
	$categoryCount =0;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}	
	return $ret;
}

function createCar($mysqli_link, $cat_name, $parent_id, $time_id, $sort_order, $keywords){

	if(isExistCarBrandOrSeries($mysqli_link, $cat_name, $parent_id)) {
		return;
	}
	$insert_sql = "INSERT INTO ecs_category".
				" (cat_name, parent_id, timer_id, keywords, cat_desc, sort_order,template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr ) ".
				"VALUES('".$cat_name."', ".$parent_id.", ".$time_id.", '".$keywords."', '', ".
				$sort_order.", '', '', '0', '', '1', '0', '')";
	$stmt = $mysqli_link->prepare($insert_sql);	
	$stmt->execute();	
	clearStoredResults($mysqli_link);								
}

function isExistCarBrandOrSeries($mysqli_link, $cat_name, $parent_id) {
	$query_str = "select count(*) from ecs_category where cat_name='".$cat_name.
		"' and parent_id=".$parent_id;				
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			if($row[0] > 0) {
				//echo 'cat name is'.$cat_name;
				$ret = true;					
			}							
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}

/*
  得到所有的车品牌 
*/
function getCarBrand($mysqli_link) {
	$selectCategory1Str =  "select cat_id, cat_name from ecs_category  where parent_id = 1";
	$category1Result = $mysqli_link->query($selectCategory1Str);

	if ($category1Result && $category1Result->num_rows > 0){
		$index = 0;
		while($category1Row = $category1Result->fetch_array() ){
			$carBrand = new CarBrand();		
			$carBrand->brandId = $category1Row[0];
			$carBrand->brandName = $category1Row[1];
			$carBrandArr[$index] =$carBrand;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $carBrandArr;
}

/*
  得到所有的车系列
*/
function getCarSeries($mysqli_link) {
	$searchCarSeriesStr =  "select carSeries.cat_id as seriesId, carSeries.cat_name as seriesName,
							carBrand.cat_id as brandId, carBrand.cat_name as brandName							
							from ecs_category as carSeries
							inner join ecs_category as carBrand
							on carSeries.parent_id = carBrand.cat_id							
							where carBrand.parent_id = 1 
							and carSeries.sort_order =110";
								
	$category1Result = $mysqli_link->query($searchCarSeriesStr);

	if ($category1Result && $category1Result->num_rows > 0){
		$index = 0;
		while($category1Row = $category1Result->fetch_array() ){
			$carSeries = new CarSeries();	
			$carSeries->seriesId =$category1Row[0];
			$carSeries->seriesName = $category1Row[1];
			$carSeries->brandId = $category1Row[2];
			$carSeries->brandName = $category1Row[3];
			$carSeriesArr[$index] =$carSeries;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $carSeriesArr;
}



/*
  得到所有的车年份
*/
function getCarYears($mysqli_link) {
	$searchCarSeriesStr =  "select carYear.cat_id as yearId, carYear.cat_name as yearName,
		carSeries.cat_id as seriesId, carSeries.cat_name as seriesName,
		carBrand.cat_id as brandId, carBrand.cat_name as brandName							
		from ecs_category as carYear
		inner join ecs_category as carSeries
			on carYear.parent_id = carSeries.cat_id and carYear.sort_order = 120 and carSeries.sort_order = 110
		inner join ecs_category as carBrand
            on carSeries.parent_id = carBrand.cat_id and carBrand.sort_order = 100";
								
	$category1Result = $mysqli_link->query($searchCarSeriesStr);

	if ($category1Result && $category1Result->num_rows > 0){
		$index = 0;
		while($category1Row = $category1Result->fetch_array() ){
			$carYear = new CarYear();			
			$carYear->yearId = $category1Row[0];
			$carYear->yearName =$category1Row[1];
			$carYear->seriesId =$category1Row[2];
			$carYear->seriesName = $category1Row[3];
			$carYear->brandId = $category1Row[4];
			$carYear->brandName = $category1Row[5];
			$carYearArr[$index] =$carYear;
			$index++;			
		}
	}
	clearStoredResults($mysqli_link);
	return $carYearArr;
}




/*
*/
function createCarYear($mysqli_link, $cat_id, $cat_name, $parent_id, $time_id, $sort_order, $keywords){
	$insert_sql = "INSERT INTO ecs_category".
				" (cat_id, cat_name, parent_id, timer_id, keywords, cat_desc, sort_order,template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr ) ".
				"VALUES(".$cat_id.", '".$cat_name."', ".$parent_id.", ".$time_id.", '".$keywords."', '', ".
				$sort_order.", '', '', '0', '', '1', '0', '')";
	$stmt = $mysqli_link->prepare($insert_sql);	
	$stmt->execute();	
	clearStoredResults($mysqli_link);								
}

/*
*/
function createCarType($mysqli_link, $cat_id, $cat_name, $parent_id, $time_id, $sort_order, $keywords){	
	$insert_sql = "INSERT INTO ecs_category".
				" (cat_id, cat_name, parent_id, timer_id, keywords, cat_desc, sort_order,template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr ) ".
				"VALUES(".$cat_id.", '".$cat_name."', ".$parent_id.", ".$time_id.", '".$keywords."', '', ".
				$sort_order.", '', '', '0', '', '1', '0', '')";
	$stmt = $mysqli_link->prepare($insert_sql);	
	$stmt->execute();	
	clearStoredResults($mysqli_link);
}


function isExistCarYear($mysqli_link, $carSeriesId, $year) {
	$query_str = "select count(*) from ecs_category where cat_name='".$year.
		"' and parent_id=".$carSeriesId;		
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			if ($row[0] >0) {
				$ret = true;	
			}
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}

function getCarYearId($mysqli_link, $carSeriesId, $carYear) {
	$query_str = "select cat_id from ecs_category where cat_name='".$carYear.
		"' and parent_id=".$carSeriesId;		
	
	$result = $mysqli_link->query($query_str);
	$ret = 0;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){					
			$ret = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}


function getCarTypeId($mysqli_link, $carYearId, $carType) {
	$query_str = "select cat_id from ecs_category where cat_name='".$carType.
		"' and parent_id=".$carYearId;		
	$result = $mysqli_link->query($query_str);
	$ret = 0;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$ret = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}




function isExistCarType($mysqli_link, $carYearId, $carType) {
	$query_str = "select count(*) from ecs_category where sort_order=130 and cat_name='".$carType.
		"' and parent_id=".$carYearId;		
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			if($row[0] >0) {
				//echo 'this should never happen, yearId is'. $carYearId. ', car type'.$carType ;
				$ret = true;	
			}
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}  

function isExistCarModel($mysqli_link, $modelName, $carTypeId ){
	$query_str = "select count(*) from ecs_category where cat_name='".$modelName.
		"' and parent_id=".$carTypeId;			
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			if ($row[0] >0) {
				$ret = true;	
			}
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}

function checkDuplicatedCarTimerId($mysqli_link, $time_id) {
	$query_str = "select count(*) from ecs_category where timer_id='".$time_id."'";		
	$result = $mysqli_link->query($query_str);
	$ret = false;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			if ($row[0] >0) {
				$ret = true;	
			}
		}
	}
	clearStoredResults($mysqli_link);	
	return $ret;
}
/*
*/
function createCarModel($mysqli_link,   $cat_name, $parent_id, $time_id, $sort_order, $keywords){
	
	if(isExistCarModel($mysqli_link, $cat_name, $parent_id)){		
		return;
	}
	if(checkDuplicatedCarTimerId($mysqli_link,$time_id)){
		echo 'this should never happen';
		return;
	}
	
	$insert_sql = "INSERT INTO ecs_category".
				" (cat_name, parent_id, timer_id, keywords, cat_desc, sort_order,template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr ) ".
				"VALUES('".$cat_name."', ".$parent_id.", ".$time_id.", '".$keywords."', '', ".
				$sort_order.", '', '', '0', '', '1', '0', '')";
	$stmt = $mysqli_link->prepare($insert_sql);	
	$stmt->execute();	
	clearStoredResults($mysqli_link);		
}

function getCatIdByAccessoryAndSubPart($mysqli_link, $subPartName, $accessoryName) {

	$queryStr = "select accessory.cat_id as accessoryId from  ecs_category as accessory 
				inner join ecs_category as subPart
				on accessory.parent_id = subPart.cat_id
				and accessory.cat_name = '".$accessoryName.
				"' and subPart.cat_name = '".$subPartName."'";
	
	$queryResult = $mysqli_link->query($queryStr);
	$accessoryId = -1;
	if ($queryResult && $queryResult->num_rows > 0){		
		$row = $queryResult->fetch_array() ;				
		$accessoryId = $row[0];		
	}
	clearStoredResults($mysqli_link);
	return $accessoryId;			
}

function getCarIdByTimexId($mysqli_link, $tidArr) {
    //select * from ecs_category where timer_id in ('7437','7443');
	$queryStr = "select cat_id from ecs_category where timer_id in ( '";
	$len = count($tidArr);
	for($i = 0; $i < $len; $i++){
		$queryStr = $queryStr.$tidArr[$i]."' ,'";
	}
	$strLeng = strlen($queryStr);
	$newQueryStr = substr($queryStr, 0, $strLeng-2);
	$newQueryStr = $newQueryStr.")";
	
	
	
	$queryResult = $mysqli_link->query($newQueryStr);	
	
	if ($queryResult && $queryResult->num_rows > 0){				
		$index = 0;
		while($row = $queryResult->fetch_array() ){
			$carIdArr[$index] = $row[0];		
			$index++;		
		}	
	}
	clearStoredResults($mysqli_link);
	return $carIdArr;	
	
	
}
?>