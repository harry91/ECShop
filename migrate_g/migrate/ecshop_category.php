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
	$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, '配件分类', '0','', ?, 60, '', '', '2', '', '1', '0', '0')";
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
	$insert_sql = "INSERT INTO ecs_category VALUES (?, ?, '配件分类', '0','', ?, 70, '', '', '3', '', '1', '0', '0')";
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
	echo $query_str."<br/>";
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
function createBrand($mysqli_link, $brandId, $brandName) {    
	if(isExistBrand($mysqli_link,$brandName)){
		echo $brandName.'已经存在';
		return;
	}
	$insert_sql = "INSERT INTO ecs_brand ( brand_name, brand_desc)VALUES ( ?, ?)";
	$stmt = $mysqli_link->prepare($insert_sql);
	$stmt->bind_param('ss',$brandName, $brandDesc);		
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
	$brandId = 1;
	$result=$mysqli_link->query('select brand_id from ecs_brand where brand_name = \''.$brandName.'\'');	
	if ($result && $result->num_rows>0) {
		$row = $result-> fetch_array();
		if ($row) {			
			$brandId = $row[0];		
		}
	}
	clearStoredResults($mysqli_link);	
	return $brandId;
}

function createBrand2Category($mysqli_link, $brandName, $categoryName) {
	$categoryId = getCategory1Id($mysqli_link, $categoryName);
	$brandId = getBrandId($mysqli_link, $brandName);
	if(isExistBrand2Category($mysqli_link,$brandId, $categoryId)){
		echo $brandName.'与'.$categoryName.' 关联已经建立<br/>';
		return;
	}
	$insert_sql = "INSERT INTO ecs_brand2Category ( brand_id, cat_id)VALUES ( ?, ?)";
	$stmt = $mysqli_link->prepare($insert_sql);
	$stmt->bind_param('ss',$brandId, $categoryId);		
	$stmt->execute();	
	clearStoredResults($mysqli_link);	
}

/*
*/
function isExistBrand2Category($mysqli_link,$brandId, $categoryId){
	$query_str = 'select count(*) from ecs_brand2category where brand_id='.$brandId.' and cat_id = '.$categoryId;
	echo "query_str:".$query_str."<br/>";
	$result = $mysqli_link->query($query_str);
	$ret = false;
	$categoryCount =0;
	if($result && $result->num_rows>0){
		$row = $result-> fetch_array();
		if($row){			
			$categoryCount = $row[0];		
		}
	}
	echo "count:".$categoryCount."<br/>";
	clearStoredResults($mysqli_link);
	if($categoryCount >0) {
		$ret = true;		
	}	
	return $ret;
}
?>