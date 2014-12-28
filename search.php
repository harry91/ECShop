<?php

/**
 * ECSHOP 搜索程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: search.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

if (!function_exists("htmlspecialchars_decode"))
{
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
    {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

//让search的url变简洁
//if (empty($_GET['encode']))
//{
//    $string = array_merge($_GET, $_POST);
//    if (get_magic_quotes_gpc())
//    {
//        require(dirname(__FILE__) . '/includes/lib_base.php');
//        //require(dirname(__FILE__) . '/includes/lib_common.php');
//
//        $string = stripslashes_deep($string);
//    }
//    $string['search_encode_time'] = time();
//    $string = str_replace('+', '%2b', base64_encode(serialize($string)));
//
//    header("Location: search.php?encode=$string\n");
//
//    exit;
//}
//else
//{
//    $string = base64_decode(trim($_GET['encode']));
//    if ($string !== false)
//    {
//        $string = unserialize($string);
//        if ($string !== false)
//        {
//            /* 用户在重定向的情况下当作一次访问 */
//            if (!empty($string['search_encode_time']))
//            {
//                if (time() > $string['search_encode_time'] + 2)
//                {
//                    define('INGORE_VISIT_STATS', true);
//                }
//            }
//            else
//            {
//                define('INGORE_VISIT_STATS', true);
//            }
//        }
//        else
//        {
//            $string = array();
//        }
//    }
//    else
//    {
//        $string = array();
//    }
//}

require(dirname(__FILE__) . '/includes/init.php');

//处理AJAX请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'query_sub_car_series' || $act == 'query_sub_car_year' || $act == 'query_sub_car_capacity' || $act == 'query_sub_car_types')
{
	$catId=$_GET['cat_id'];
	$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$catId;
	$car_types =  $GLOBALS['db']->getAll($one_sql);
	
	include_once('includes/cls_json.php');
	$json = new JSON;
    die($json->encode($car_types));
}else if ($act == 'query_sub_car_types_by_series')
{
	$catId=$_GET['cat_id'];
	$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id IN ( SELECT cat_id FROM ecs_category WHERE parent_id IN( SELECT cat_id FROM ecs_category WHERE parent_id = ".$catId." ))";
	$car_types =  $GLOBALS['db']->getAll($one_sql);
	
	include_once('includes/cls_json.php');
	$json = new JSON;
    die($json->encode($car_types));
}
//else if ($act == 'query_sub_car_year')
//{
//	$catId=$_GET['cat_id'];
//	$one_sql = "SELECT distinct(cat_year.cat_name) FROM ecs_category cat_year, (SELECT cat_id FROM ecs_category WHERE parent_id = ".$catId.") as type_before_year where type_before_year.cat_id=cat_year.parent_id";
//	$car_types =  $GLOBALS['db']->getAll($one_sql);
//	
//	include_once('includes/cls_json.php');
//	$json = new JSON;
//    die($json->encode($car_types));
//}else if ($act == 'query_sub_car_capacity'){
//	$catId=$_GET['cat_id'];
//	$carYear=$_GET['carYear'];
//	$one_sql ="select distinct(cat_capacity.cat_name) from ecs_category cat_capacity, ".
//	"(SELECT distinct(cat_year.cat_id) FROM ecs_category cat_year, (SELECT cat_id FROM ecs_category WHERE parent_id = ".$catId.") as type_before_year where type_before_year.cat_id=cat_year.parent_id and cat_year.cat_name='".$carYear."') as cat_year".
//	" where cat_year.cat_id=cat_capacity.parent_id";
//	
//	$car_types =  $GLOBALS['db']->getAll($one_sql);
//	
//	include_once('includes/cls_json.php');
//	$json = new JSON;
//    die($json->encode($car_types));
//}else if ($act == 'query_sub_car_capacity'){
//	$catId=$_GET['cat_id'];
//	$carYear=$_GET['carYear'];
//	$one_sql ="select distinct(cat_capacity.cat_name) from ecs_category cat_capacity, ".
//	"(SELECT distinct(cat_year.cat_id) FROM ecs_category cat_year, (SELECT cat_id FROM ecs_category WHERE parent_id = ".$catId.") as type_before_year where type_before_year.cat_id=cat_year.parent_id and cat_year.cat_name='".$carYear."') as cat_year".
//	" where cat_year.cat_id=cat_capacity.parent_id";
//	
//	$car_types =  $GLOBALS['db']->getAll($one_sql);
//	
//	include_once('includes/cls_json.php');
//	$json = new JSON;
//    die($json->encode($car_types));
//}else if ($act == 'query_sub_car_types'){
//	$catId=$_GET['cat_id'];
//	$carYear=$_GET['carYear'];
//	$carCapacity=$_GET['carCapacity'];
//	
//	$resultIndex = 0;
//	$car_types = getCategorySelection($catId);
//	foreach($car_types as $one_car_type){
//		$car_types_2 =  getCategorySelection($one_car_type['cat_id']);//年款
//		foreach($car_types_2 as $one_car_type_2){
//			if(!strstr($carYear, $one_car_type_2['cat_name'])){
//				continue;
//			}
//			$car_types_3 = getCategorySelection($one_car_type_2['cat_id']);//排量
//			foreach($car_types_3 as $one_car_type_3){
//				if(!strstr($carCapacity, $one_car_type_3['cat_name'])){
//					continue;
//				}
//				$car_types_4 = getCategorySelection($one_car_type_3['cat_id']);
//				if(count($car_types_4) == 0){
//					if($one_car_type['cat_name'] == "null_type"){
//						$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'];
//					}else{
//						$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type['cat_name'].' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'];
//					}
//					$retTypes[$resultIndex]['cat_id']=$one_car_type_3['cat_id'];
//					$resultIndex++;
//				}else{
//					foreach($car_types_4 as $one_car_type_4){
//						if($one_car_type['cat_name'] == "null_type"){
//							$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'].' '.$one_car_type_4['cat_name'];
//						}else{
//							$retTypes[$resultIndex]['name']=$catName.' '.$one_car_type['cat_name'].' '.$one_car_type_2['cat_name'].' '.$one_car_type_3['cat_name'].' '.$one_car_type_4['cat_name'];
//						}
//						$retTypes[$resultIndex]['cat_id']=$one_car_type_4['cat_id'];
//						$resultIndex++;
//					}
//				}
//			}
//		}
//	}
//	
//	include_once('includes/cls_json.php');
//	$json = new JSON;
//    die($json->encode($retTypes));
//}
//完成AJAX请求的处理

//$_REQUEST = array_merge($_REQUEST, addslashes_deep($string));//让search的url变简洁

$_REQUEST['act'] = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '';

/*------------------------------------------------------ */
//-- 高级搜索
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'advanced_search')
{
    $goods_type = !empty($_REQUEST['goods_type']) ? intval($_REQUEST['goods_type']) : 0;
    $attributes = get_seachable_attributes($goods_type);
    $smarty->assign('goods_type_selected', $goods_type);
    $smarty->assign('goods_type_list',     $attributes['cate']);
    $smarty->assign('goods_attributes',    $attributes['attr']);

    assign_template();
    assign_dynamic('search');
    $position = assign_ur_here(0, $_LANG['advanced_search']);
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置

    $smarty->assign('categories', get_categories_tree()); // 分类树
    $smarty->assign('helps',      get_shop_help());       // 网店帮助
    $smarty->assign('top_goods',  get_top10());           // 销售排行
    $smarty->assign('promotion_info', get_promotion_info());
    //$smarty->assign('cat_list',   cat_list(0, 0, true, 2, false));
    $smarty->assign('brand_list', get_brand_list());
    $smarty->assign('action',     'form');
    $smarty->assign('use_storage', $_CFG['use_storage']);

    $smarty->display('search.dwt');

    exit;
}
/*------------------------------------------------------ */
//-- 搜索结果
/*------------------------------------------------------ */
else
{
    $_REQUEST['keywords']   = !empty($_REQUEST['keywords'])   ? htmlspecialchars(trim($_REQUEST['keywords']))     : '';
	$_REQUEST['related_stock_code']   = !empty($_REQUEST['related_stock_code'])   ? htmlspecialchars(trim($_REQUEST['related_stock_code']))     : '';
    $_REQUEST['brand']      = !empty($_REQUEST['brand'])      ? intval($_REQUEST['brand'])      : 0;
	$_REQUEST['category_level']= !empty($_REQUEST['category_level'])   ? intval($_REQUEST['category_level'])   : 0;
	$_REQUEST['car_cat_level']= !empty($_REQUEST['car_cat_level'])   ? intval($_REQUEST['car_cat_level'])   : 0;
    $_REQUEST['category']   = !empty($_REQUEST['category'])   ? intval($_REQUEST['category'])   : 2;
	$_REQUEST['car_category']= !empty($_REQUEST['car_category'])   ? intval($_REQUEST['car_category'])   : 0;//用于搜索扩展分类（车型分类）
	$_REQUEST['car_category_for_display'] = !empty($_REQUEST['car_category_for_display'])   ? htmlspecialchars(trim($_REQUEST['car_category_for_display']))     : '';//用于在搜索结果页显示扩展分类（车型分类）
    $_REQUEST['min_price']  = !empty($_REQUEST['min_price'])  ? intval($_REQUEST['min_price'])  : 0;
    $_REQUEST['max_price']  = !empty($_REQUEST['max_price'])  ? intval($_REQUEST['max_price'])  : 0;
    $_REQUEST['goods_type'] = !empty($_REQUEST['goods_type']) ? intval($_REQUEST['goods_type']) : 0;
    $_REQUEST['sc_ds']      = !empty($_REQUEST['sc_ds']) ? intval($_REQUEST['sc_ds']) : 0;
    $_REQUEST['outstock']   = !empty($_REQUEST['outstock']) ? 1 : 0;
	
	$_REQUEST['goods_sn']   = !empty($_REQUEST['goods_sn']) ? $_REQUEST['goods_sn'] : 0;

    $action = '';
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'form')
    {
        /* 要显示高级搜索栏 */
        $adv_value['keywords']  = htmlspecialchars(stripcslashes($_REQUEST['keywords']));
        $adv_value['brand']     = $_REQUEST['brand'];
        $adv_value['min_price'] = $_REQUEST['min_price'];
        $adv_value['max_price'] = $_REQUEST['max_price'];
        $adv_value['category']  = $_REQUEST['category'];

        $attributes = get_seachable_attributes($_REQUEST['goods_type']);

        /* 将提交数据重新赋值 */
        foreach ($attributes['attr'] AS $key => $val)
        {
            if (!empty($_REQUEST['attr'][$val['id']]))
            {
                if ($val['type'] == 2)
                {
                    $attributes['attr'][$key]['value']['from'] = !empty($_REQUEST['attr'][$val['id']]['from']) ? htmlspecialchars(stripcslashes(trim($_REQUEST['attr'][$val['id']]['from']))) : '';
                    $attributes['attr'][$key]['value']['to']   = !empty($_REQUEST['attr'][$val['id']]['to'])   ? htmlspecialchars(stripcslashes(trim($_REQUEST['attr'][$val['id']]['to'])))   : '';
                }
                else
                {
                    $attributes['attr'][$key]['value'] = !empty($_REQUEST['attr'][$val['id']]) ? htmlspecialchars(stripcslashes(trim($_REQUEST['attr'][$val['id']]))) : '';
                }
            }
        }
        if ($_REQUEST['sc_ds'])
        {
            $smarty->assign('scck',            'checked');
        }
        $smarty->assign('adv_val',             $adv_value);
        $smarty->assign('goods_type_list',     $attributes['cate']);
        $smarty->assign('goods_attributes',    $attributes['attr']);
        $smarty->assign('goods_type_selected', $_REQUEST['goods_type']);
        //$smarty->assign('cat_list',            cat_list(0, $adv_value['category'], true, 2, false));
        $smarty->assign('brand_list',          get_brand_list());
        $smarty->assign('action',              'form');
        $smarty->assign('use_storage',          $_CFG['use_storage']);

        $action = 'form';
    }

    /* 初始化搜索条件 */
    $keywords  = '';
    $tag_where = '';
	
	
    if (!empty($_REQUEST['keywords']))
    {
        $arr = array();
        if (stristr($_REQUEST['keywords'], ' AND ') !== false)
        {
            /* 检查关键字中是否有AND，如果存在就是并 */
            $arr        = explode('AND', $_REQUEST['keywords']);
            $operator   = " AND ";
        }
        elseif (stristr($_REQUEST['keywords'], ' OR ') !== false)
        {
            /* 检查关键字中是否有OR，如果存在就是或 */
            $arr        = explode('OR', $_REQUEST['keywords']);
            $operator   = " OR ";
        }
        elseif (stristr($_REQUEST['keywords'], ' + ') !== false)
        {
            /* 检查关键字中是否有加号，如果存在就是或 */
            $arr        = explode('+', $_REQUEST['keywords']);
            $operator   = " OR ";
        }
        else
        {
            /* 检查关键字中是否有空格，如果存在就是并 */
            $arr        = explode(' ', $_REQUEST['keywords']);
            $operator   = " AND ";
        }

        $keywords = 'AND (';
        $goods_ids = array();
        foreach ($arr AS $key => $val)
        {
            if ($key > 0 && $key < count($arr) && count($arr) > 1)
            {
                $keywords .= $operator;
            }
            $val        = mysql_like_quote(trim($val));
            $sc_dsad    = $_REQUEST['sc_ds'] ? " OR goods_desc LIKE '%$val%'" : '';
            $keywords  .= "(goods_name LIKE '%$val%' OR goods_sn LIKE '%$val%' OR keywords LIKE '%$val%' $sc_dsad)";

            $sql = 'SELECT DISTINCT goods_id FROM ' . $ecs->table('tag') . " WHERE tag_words LIKE '%$val%' ";
            $res = $db->query($sql);
            while ($row = $db->FetchRow($res))
            {
                $goods_ids[] = $row['goods_id'];
            }

            $db->autoReplace($ecs->table('keywords'), array('date' => local_date('Y-m-d'),
                'searchengine' => 'ecshop', 'keyword' => addslashes(str_replace('%', '', $val)), 'count' => 1), array('count' => 1));
        }
        $keywords .= ')';

        $goods_ids = array_unique($goods_ids);
        $tag_where = implode(',', $goods_ids);
        if (!empty($tag_where))
        {
            $tag_where = 'OR g.goods_id ' . db_create_in($tag_where);
        }
    }
	
	//echo get_goods_bottom_cat_ids()."<br/>";
	//die(get_children_str($category));
	
	$category_level=!empty($_REQUEST['category_level']) ? intval($_REQUEST['category_level']): 0;
	$car_cat_level=!empty($_REQUEST['car_cat_level']) ? intval($_REQUEST['car_cat_level']): 0;
    $category   = !empty($_REQUEST['category']) ? intval($_REQUEST['category'])        : 2;
	
	/*以下用于搜索扩展分类（车型分类）*/
	$car_category=!empty($_REQUEST['car_category']) ? intval($_REQUEST['car_category']): 0;
	
	if($category > 2 && $car_category <= 1){
		$categories = ' AND ' . get_goods_bottom_cat_ids($category_level, $category);
//		$categories = ' AND ' . get_children($category);
	}else if($category <= 2 && $car_category > 1){
		$categories = ' AND (' . "g.goods_id in (select goods_id from ecs_goods_cat where cat_id  " . get_car_bottom_cat_ids($car_cat_level, $car_category) . " )  )";//添加的这一行和上面注释的这一行是为了对扩展分类进行搜索
		//print_r($categories);
		//$categories = ' AND (' . "g.goods_id in (select goods_id from ecs_goods_cat where cat_id  " . get_children_str($car_category) . " )  )";//添加的这一行和上面注释的这一行是为了对扩展分类进行搜索
	}else if($category > 2 && $car_category > 1){
		//$categories = ' AND (' . get_goods_bottom_cat_ids($category_level, $category) . " and g.goods_id in (select goods_id from ecs_goods_cat where cat_id  " . get_children_str($car_category) . " )  )";
		$categories = ' AND (' . get_goods_bottom_cat_ids($category_level, $category) . " and g.goods_id in (select goods_id from ecs_goods_cat where cat_id  " . get_car_bottom_cat_ids($car_cat_level, $car_category) . " )  )";
		//$categories = ' AND (' . get_children($category) . " and g.goods_id in (select goods_id from ecs_goods_cat where cat_id  " . get_children_str($car_category) . " )  )";
	}else{
		$categories='';
	}
	/*以上用于搜索扩展分类（车型分类）*/
	
    //$categories = ($category > 0)               ? ' AND ' . get_children($category)    : '';
	//$categories = ($category > 0)               ? ' AND (' . get_children($category) . " or g.goods_id in (select goods_id from ecs_goods_cat where cat_id  " . get_children_str($category) . " )  )"   : '';//添加的这一行和上面注释的这一行是为了对扩展分类进行搜索
	
	
	//以下根据stock_code搜索同类产品的sock_code
	$related_stock_code=!empty($_REQUEST['related_stock_code']) ? $_REQUEST['related_stock_code'] : '';
	$stock_codes="";
	if($related_stock_code != ''){
		$stock_codes=getRelatedStockCodes($related_stock_code);
	}
		
    $brand      = $_REQUEST['brand']            ? " AND brand_id = '$_REQUEST[brand]'" : '';
	$goods_sn   = $_REQUEST['goods_sn']         ? " AND goods_sn = '$_REQUEST[goods_sn]'" : '';
    $outstock   = !empty($_REQUEST['outstock']) ? " AND g.goods_number > 0 "           : '';

    $min_price  = $_REQUEST['min_price'] != 0                               ? " AND g.shop_price >= '$_REQUEST[min_price]'" : '';
    $max_price  = $_REQUEST['max_price'] != 0 || $_REQUEST['min_price'] < 0 ? " AND g.shop_price <= '$_REQUEST[max_price]'" : '';

    /* 排序、显示方式以及类型 */
    $default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
    $default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
    $default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'shop_price' : 'last_update');

    $sort = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'shop_price', 'last_update'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
    $order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC'))) ? trim($_REQUEST['order']) : $default_sort_order_method;
    $display  = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_SESSION['display_search']) ? $_SESSION['display_search'] : $default_display_type);

    $_SESSION['display_search'] = $display;

    $page       = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size       = !empty($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

    $intromode = '';    //方式，用于决定搜索结果页标题图片

    if (!empty($_REQUEST['intro']))
    {
        switch ($_REQUEST['intro'])
        {
            case 'best':
                $intro   = ' AND g.is_best = 1';
                $intromode = 'best';
                $ur_here = $_LANG['best_goods'];
                break;
            case 'new':
                $intro   = ' AND g.is_new = 1';
                $intromode ='new';
                $ur_here = $_LANG['new_goods'];
                break;
            case 'hot':
                $intro   = ' AND g.is_hot = 1';
                $intromode = 'hot';
                $ur_here = $_LANG['hot_goods'];
                break;
            case 'promotion':
                $time    = gmtime();
                $intro   = " AND g.promote_price > 0 AND g.promote_start_date <= '$time' AND g.promote_end_date >= '$time'";
                $intromode = 'promotion';
                $ur_here = $_LANG['promotion_goods'];
                break;
            default:
                $intro   = '';
        }
    }
    else
    {
        $intro = '';
    }

    if (empty($ur_here))
    {
        $ur_here = $_LANG['search_goods'];
    }

    /*------------------------------------------------------ */
    //-- 属性检索
    /*------------------------------------------------------ */
    $attr_in  = '';
    $attr_num = 0;
    $attr_url = '';
    $attr_arg = array();

    if (!empty($_REQUEST['attr']))
    {
        $sql = "SELECT goods_id, COUNT(*) AS num FROM " . $ecs->table("goods_attr") . " WHERE 0 ";
        foreach ($_REQUEST['attr'] AS $key => $val)
        {
            if (is_not_null($val) && is_numeric($key))
            {
                $attr_num++;
                $sql .= " OR (1 ";

                if (is_array($val))
                {
                    $sql .= " AND attr_id = '$key'";

                    if (!empty($val['from']))
                    {
                        $sql .= is_numeric($val['from']) ? " AND attr_value >= " . floatval($val['from'])  : " AND attr_value >= '$val[from]'";
                        $attr_arg["attr[$key][from]"] = $val['from'];
                        $attr_url .= "&amp;attr[$key][from]=$val[from]";
                    }

                    if (!empty($val['to']))
                    {
                        $sql .= is_numeric($val['to']) ? " AND attr_value <= " . floatval($val['to']) : " AND attr_value <= '$val[to]'";
                        $attr_arg["attr[$key][to]"] = $val['to'];
                        $attr_url .= "&amp;attr[$key][to]=$val[to]";
                    }
                }
                else
                {
                    /* 处理选购中心过来的链接 */
                    $sql .= isset($_REQUEST['pickout']) ? " AND attr_id = '$key' AND attr_value = '" . $val . "' " : " AND attr_id = '$key' AND attr_value LIKE '%" . mysql_like_quote($val) . "%' ";
                    $attr_url .= "&amp;attr[$key]=$val";
                    $attr_arg["attr[$key]"] = $val;
                }

                $sql .= ')';
            }
        }

        /* 如果检索条件都是无效的，就不用检索 */
        if ($attr_num > 0)
        {
            $sql .= " GROUP BY goods_id HAVING num = '$attr_num'";

            $row = $db->getCol($sql);
            if (count($row))
            {
                $attr_in = " AND " . db_create_in($row, 'g.goods_id');
            }
            else
            {
                $attr_in = " AND 0 ";
            }
        }
    }
    elseif (isset($_REQUEST['pickout']))
    {
        /* 从选购中心进入的链接 */
        $sql = "SELECT DISTINCT(goods_id) FROM " . $ecs->table('goods_attr');
        $col = $db->getCol($sql);
        //如果商店没有设置商品属性,那么此检索条件是无效的
        if (!empty($col))
        {
            $attr_in = " AND " . db_create_in($col, 'g.goods_id');
        }
    }

    /* 获得符合条件的商品总数 */
    $sql   = "SELECT COUNT(*) FROM " .$ecs->table('goods'). " AS g ".
        "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
        "AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . $goods_sn . $stock_codes ." ) ".$tag_where." )";
    $count = $db->getOne($sql);

    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }

    /* 查询商品 */
    $sql = "SELECT g.goods_id, g.goods_name, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ".
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                "g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type ".
            "FROM " .$ecs->table('goods'). " AS g ".
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
                "AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . $goods_sn . $stock_codes ." ) ".$tag_where." ) " .
            "ORDER BY $sort $order";
	
    $res = $db->SelectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $db->FetchRow($res))
    {
        if ($row['promote_price'] > 0)
        {
            $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
        }
        else
        {
            $promote_price = 0;
        }

        /* 处理商品水印图片 */
        /* 处理商品水印图片 */
        $watermark_img = '';

        if ($promote_price != 0)
        {
            $watermark_img = "watermark_promote_small";
        }
        elseif ($row['is_new'] != 0)
        {
            $watermark_img = "watermark_new_small";
        }
        elseif ($row['is_best'] != 0)
        {
            $watermark_img = "watermark_best_small";
        }
        elseif ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot_small';
        }

        if ($watermark_img != '')
        {
            $arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
        }

        $arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        if($display == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']    = sub_str($row['goods_name'], 35);//$GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
        }
        $arr[$row['goods_id']]['type']          = $row['goods_type'];
        $arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
        $arr[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
    }
	
	/*如果配件分类未设定，则获取配件分类的一级分类*/
//	if($car_category==0){
//		$subCategoriesSql="select cat_id, cat_name from ecs_category where parent_id = ".$category;
//		$subCategories =  $GLOBALS['db']->getAll($subCategoriesSql);
//		$smarty->assign('subCategories', $subCategories);
//	}else{
		if($category_level==0){
			
			$subCategoriesSql = 
			"select ecs_category_3.cat_id, ecs_category_3.cat_name from ecs_category ecs_category_3, ".
			"(select distinct(ecs_category_2.parent_id) from ecs_category ecs_category_2, ".
			"(select distinct(ecs_category_1.parent_id) from ecs_category ecs_category_1 , ".
		
			"(SELECT distinct(g.cat_id) FROM " .$ecs->table('goods'). " AS g ".
        	"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
        	"AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . $goods_sn ." ) ".$tag_where." )) as goods ".
		
			"where ecs_category_1.cat_id = goods.cat_id) as ecs_category_1 ".
			"where ecs_category_1.parent_id = ecs_category_2.cat_id) as ecs_category_2 ".
			"where ecs_category_2.parent_id = ecs_category_3.cat_id";

			$subCategories =  $GLOBALS['db']->getAll($subCategoriesSql);
			$smarty->assign('subCategories', $subCategories);
			
		}else if($category_level==1){
			
			$subCategoriesSql = 
			"select ecs_category_2.cat_id, ecs_category_2.cat_name from ecs_category ecs_category_2, ".
			"(select distinct(ecs_category_1.parent_id) from ecs_category ecs_category_1 , ".
		
			"(SELECT distinct(g.cat_id) FROM " .$ecs->table('goods'). " AS g ".
        	"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
        	"AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . $goods_sn ." ) ".$tag_where." )) as goods ".
		
			"where ecs_category_1.cat_id = goods.cat_id) as ecs_category_1 ".
			"where ecs_category_1.parent_id = ecs_category_2.cat_id";
			
			$subCategories =  $GLOBALS['db']->getAll($subCategoriesSql);
			$smarty->assign('subCategories', $subCategories);
			
		}else if($category_level==2){
			$subCategoriesSql = 
			"select ecs_category_1.cat_id, ecs_category_1.cat_name from ecs_category ecs_category_1, ".
		
			"(SELECT distinct(g.cat_id) FROM " .$ecs->table('goods'). " AS g ".
        	"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
        	"AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . $goods_sn . " ) ".$tag_where." )) as goods ".

			"where goods.cat_id = ecs_category_1.cat_id";
			
			$subCategories =  $GLOBALS['db']->getAll($subCategoriesSql);
			$smarty->assign('subCategories', $subCategories);
		}else if($category_level==3){
			$smarty->assign('subCategories', array());
		}else{
			print_r("category_level error");
		}
//	}
	
	if($category > 2){
		$getCategoryNameSql="select cat_name from ecs_category where ecs_category.cat_id=".$category;
		$categoryName = $GLOBALS['db']->getOne($getCategoryNameSql);
		$smarty->assign('categoryName', $categoryName);
	}
	
	if(!$_REQUEST['brand']){
		$getBrandSql=
		"select ecs_brand.brand_id, ecs_brand.brand_name from ecs_brand, ".
		"(SELECT distinct(g.brand_id) FROM " .$ecs->table('goods'). " AS g ".
        "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
        "AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . $goods_sn . " ) ".$tag_where." )) as goods ".
		"where goods.brand_id=ecs_brand.brand_id";
		$brands = $GLOBALS['db']->getAll($getBrandSql);
		$smarty->assign('brands', $brands);
	}else{
		$smarty->assign('brandName', $_REQUEST['brandName']);
	}

    if($display == 'grid')
    {
        if(count($arr) % 2 != 0)
        {
            $arr[] = array();
        }
    }
    $smarty->assign('goods_list', $arr);
    $smarty->assign('category',   $category);
	//$smarty->assign('car_category', $car_category);//用于搜索扩展分类（车型分类）
    $smarty->assign('keywords',   htmlspecialchars(stripslashes($_REQUEST['keywords'])));
    $smarty->assign('search_keywords',   stripslashes(htmlspecialchars_decode($_REQUEST['keywords'])));
    $smarty->assign('brand',      $_REQUEST['brand']);
    $smarty->assign('min_price',  $min_price);
    $smarty->assign('max_price',  $max_price);
    $smarty->assign('outstock',  $_REQUEST['outstock']);
	if($_REQUEST['car_category_for_display'] != ''){
		$smarty->assign('car_category_for_display',  $_REQUEST['car_category_for_display']);
	}
	$smarty->assign('related_stock_code', $_REQUEST['related_stock_code']);

    /* 分页 */
    $url_format = "search.php?category=$category&amp;car_category=$car_category&amp;keywords=" . urlencode(stripslashes($_REQUEST['keywords'])) . "&amp;brand=" . $_REQUEST['brand']."&amp;action=".$action."&amp;goods_type=" . $_REQUEST['goods_type'] . "&amp;sc_ds=" . $_REQUEST['sc_ds'];//添加car_category=$car_category&amp;用于搜索扩展分类（车型分类）
    if (!empty($intromode))
    {
        $url_format .= "&amp;intro=" . $intromode;
    }
    if (isset($_REQUEST['pickout']))
    {
        $url_format .= '&amp;pickout=1';
    }
    $url_format .= "&amp;min_price=" . $_REQUEST['min_price'] ."&amp;max_price=" . $_REQUEST['max_price'] . "&amp;sort=$sort";

    $url_format .= "$attr_url&amp;order=$order&amp;page=";

    $pager['search'] = array(
        'keywords'   => stripslashes(urlencode($_REQUEST['keywords'])),
        'category'   => $category,
		'category_level'=>$category_level,//用于搜索扩展分类（车型分类）
		'car_cat_level'=>$car_cat_level,//用于搜索车型分类（车型分类）
		'car_category'=> $car_category,//用于搜索扩展分类（车型分类）
		'car_category_for_display'=>$_REQUEST['car_category_for_display'],//用于在搜索结果页显示扩展分类（车型分类）
		'related_stock_code'=>$_REQUEST['related_stock_code'],//用于在搜索结果页显示扩展分类（车型分类）
        'brand'      => $_REQUEST['brand'],
		'brandName'  => $_REQUEST['brandName'],
        'sort'       => $sort,
        'order'      => $order,
        'min_price'  => $_REQUEST['min_price'],
        'max_price'  => $_REQUEST['max_price'],
        'action'     => $action,
        'intro'      => empty($intromode) ? '' : trim($intromode),
        'goods_type' => $_REQUEST['goods_type'],
        'sc_ds'      => $_REQUEST['sc_ds'],
        'outstock'   => $_REQUEST['outstock']
    );
    $pager['search'] = array_merge($pager['search'], $attr_arg);

    $pager = get_pager('search.php', $pager['search'], $count, $page, $size);
    $pager['display'] = $display;

    $smarty->assign('url_format', $url_format);
    $smarty->assign('pager', $pager);

    assign_template();
    assign_dynamic('search');
    $position = assign_ur_here(0, $ur_here . ($_REQUEST['keywords'] ? '_' . $_REQUEST['keywords'] : ''));
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置
    $smarty->assign('intromode',      $intromode);
    //$smarty->assign('categories', get_categories_tree()); // 分类树
    $smarty->assign('helps',       get_shop_help());      // 网店帮助
    //$smarty->assign('top_goods',  get_top10());           // 销售排行
    $smarty->assign('promotion_info', get_promotion_info());
	
	//获得所有汽车品牌
	$my_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = 1 ORDER BY CONVERT( cat_name USING gbk )";
	$all_car_brands =  $GLOBALS['db']->getAll($my_sql);
	for($i=0; $i<count($all_car_brands); $i++){
		$one_sql = "SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$all_car_brands[$i]['cat_id'];
		$car_types =  $GLOBALS['db']->getAll($one_sql);
		$all_car_brands[$i]['car_types']=$car_types;
		$all_car_brands[$i]['first_letter']=getfirstchar($all_car_brands[$i]['cat_name']);
	}
	$smarty->assign('all_car_brands', $all_car_brands);

    $smarty->display('search.dwt');
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */
/**
 *
 *
 * @access public
 * @param
 *
 * @return void
 */
function is_not_null($value)
{
    if (is_array($value))
    {
        return (!empty($value['from'])) || (!empty($value['to']));
    }
    else
    {
        return !empty($value);
    }
}

/**
 * 获得可以检索的属性
 *
 * @access  public
 * @params  integer $cat_id
 * @return  void
 */
function get_seachable_attributes($cat_id = 0)
{
    $attributes = array(
        'cate' => array(),
        'attr' => array()
    );

    /* 获得可用的商品类型 */
    $sql = "SELECT t.cat_id, cat_name FROM " .$GLOBALS['ecs']->table('goods_type'). " AS t, ".
           $GLOBALS['ecs']->table('attribute') ." AS a".
           " WHERE t.cat_id = a.cat_id AND t.enabled = 1 AND a.attr_index > 0 ";
    $cat = $GLOBALS['db']->getAll($sql);

    /* 获取可以检索的属性 */
    if (!empty($cat))
    {
        foreach ($cat AS $val)
        {
            $attributes['cate'][$val['cat_id']] = $val['cat_name'];
        }
        $where = $cat_id > 0 ? ' AND a.cat_id = ' . $cat_id : " AND a.cat_id = " . $cat[0]['cat_id'];

        $sql = 'SELECT attr_id, attr_name, attr_input_type, attr_type, attr_values, attr_index, sort_order ' .
               ' FROM ' . $GLOBALS['ecs']->table('attribute') . ' AS a ' .
               ' WHERE a.attr_index > 0 ' .$where.
               ' ORDER BY cat_id, sort_order ASC';
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->FetchRow($res))
        {
            if ($row['attr_index'] == 1 && $row['attr_input_type'] == 1)
            {
                $row['attr_values'] = str_replace("\r", '', $row['attr_values']);
                $options = explode("\n", $row['attr_values']);

                $attr_value = array();
                foreach ($options AS $opt)
                {
                    $attr_value[$opt] = $opt;
                }
                $attributes['attr'][] = array(
                    'id'      => $row['attr_id'],
                    'attr'    => $row['attr_name'],
                    'options' => $attr_value,
                    'type'    => 3
                );
            }
            else
            {
                $attributes['attr'][] = array(
                    'id'   => $row['attr_id'],
                    'attr' => $row['attr_name'],
                    'type' => $row['attr_index']
                );
            }
        }
    }

    return $attributes;
}

function getRelatedStockCodes($stockId){
	$timex_conn = new mysqli("115.29.208.179", "sikubo", "Sikubo@2014!", "td_all");
	if (!$timex_conn)
	{
		die('Could not connect timex database.');
	}
	$timex_conn->set_charset("utf8");
	$query =  "call p_GetPartCodeByCode('$stockId', @res)";

	$result = $timex_conn->query($query);
	
	$retStr="";
	
	if ($result) {
		//echo "成功返回结果<br/>";
		if($result->num_rows > 0){
			$retStr=" AND stock_code IN( ";
			$i=0;
			while($row = $result->fetch_array() ){
				if($i>0){
					$retStr=$retStr.", ";
				}
				$curr_stock_code = $row[1];
				$retStr=$retStr."'$curr_stock_code'";
				$i++;
			}
			$retStr=$retStr.") ";
		}
	}else {
		//echo "未返回结果";
	}
	//echo $retStr."</br>";
	return $retStr;
}

//return the first letter of chinese in pinyin
function getfirstchar($s0){   
	$fchar = ord($s0{0});
	if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
	$s1 = iconv("UTF-8","gb2312", $s0);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $s0){$s = $s1;}else{$s = $s0;}
	$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
	if($asc >= -20319 and $asc <= -20284) return "A";
	if($asc >= -20283 and $asc <= -19776) return "B";
	if($asc >= -19775 and $asc <= -19219) return "C";
	if($asc >= -19218 and $asc <= -18711) return "D";
	if($asc >= -18710 and $asc <= -18527) return "E";
	if($asc >= -18526 and $asc <= -18240) return "F";
	if($asc >= -18239 and $asc <= -17923) return "G";
	if($asc >= -17922 and $asc <= -17418) return "H";
	if($asc >= -17417 and $asc <= -16475) return "J";
	if($asc >= -16474 and $asc <= -16213) return "K";
	if($asc >= -16212 and $asc <= -15641) return "L";
	if($asc >= -15640 and $asc <= -15166) return "M";
	if($asc >= -15165 and $asc <= -14923) return "N";
	if($asc >= -14922 and $asc <= -14915) return "O";
	if($asc >= -14914 and $asc <= -14631) return "P";
	if($asc >= -14630 and $asc <= -14150) return "Q";
	if($asc >= -14149 and $asc <= -14091) return "R";
	if($asc >= -14090 and $asc <= -13319) return "S";
	if($asc >= -13318 and $asc <= -12839) return "T";
	if($asc >= -12838 and $asc <= -12557) return "W";
	if($asc >= -12556 and $asc <= -11848) return "X";
	if($asc >= -11847 and $asc <= -11056) return "Y";
	if($asc >= -11055 and $asc <= -10247) return "Z";
	return null;
}

function getCategorySelection($_cat_id){
	return $GLOBALS['db']->getAll("SELECT cat_name, cat_id FROM ecs_category WHERE parent_id = ".$_cat_id);
}
?>