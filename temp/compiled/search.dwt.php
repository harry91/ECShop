<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,common.js,global.js,compare.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/page_sub_header.lbi'); ?>

<div class="block box">
  <div id="ur_here" style="display:none;"> <?php echo $this->fetch('library/ur_here.lbi'); ?> </div>
</div>

<div class="blank"></div>
<div class="block clearfix"> 
  
  <div class="AreaL">  <?php echo $this->fetch('library/cart.lbi'); ?> <?php echo $this->fetch('library/category_tree.lbi'); ?> <?php echo $this->fetch('library/goods_related.lbi'); ?> <?php echo $this->fetch('library/goods_fittings.lbi'); ?> <?php echo $this->fetch('library/goods_article.lbi'); ?> <?php echo $this->fetch('library/goods_attrlinked.lbi'); ?>    
     
    <?php echo $this->fetch('library/history.lbi'); ?> </div>
   
  
  <div class="AreaR"> 
    <?php if ($this->_var['action'] == "form"): ?> 
    
    <div class="box">
      <div class="box_1">
        <h3><span><?php echo $this->_var['lang']['advanced_search']; ?></span></h3>
        <div class="boxCenterList">
          <form action="search.php" method="get" name="advancedSearchForm" id="advancedSearchForm">
            <table border="0" align="center" cellpadding="3">
              <tr>
                <td valign="top"><?php echo $this->_var['lang']['keywords']; ?>：</td>
                <td><input name="keywords" id="keywords" type="text" size="40" maxlength="120" class="inputBg" value="<?php echo $this->_var['adv_val']['keywords']; ?>" />
                  <label for="sc_ds">
                    <input type="checkbox" name="sc_ds" value="1" id="sc_ds" <?php echo $this->_var['scck']; ?> />
                    <?php echo $this->_var['lang']['sc_ds']; ?></label>
                  <br />
                  <?php echo $this->_var['lang']['searchkeywords_notice']; ?> </td>
              </tr>
              <tr>
                <td><?php echo $this->_var['lang']['category']; ?>：</td>
                <td><select name="category" id="select" style="border:1px solid #ccc;">
                    <option value="0"><?php echo $this->_var['lang']['all_category']; ?></option>
                    
                    
                    <?php echo $this->_var['cat_list']; ?>
                  
                  
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $this->_var['lang']['brand']; ?>：</td>
                <td><select name="brand" id="brand" style="border:1px solid #ccc;">
                    <option value="0"><?php echo $this->_var['lang']['all_brand']; ?></option>
                    
                    
                    
            <?php echo $this->html_options(array('options'=>$this->_var['brand_list'],'selected'=>$this->_var['adv_val']['brand'])); ?>
          
                  
                  
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $this->_var['lang']['price']; ?>：</td>
                <td><input name="min_price" type="text" id="min_price" class="inputBg" value="<?php echo $this->_var['adv_val']['min_price']; ?>" size="10" maxlength="8" />
                  -
                  <input name="max_price" type="text" id="max_price" class="inputBg" value="<?php echo $this->_var['adv_val']['max_price']; ?>" size="10" maxlength="8" /></td>
              </tr>
              <?php if ($this->_var['goods_type_list']): ?>
              <tr>
                <td><?php echo $this->_var['lang']['extension']; ?>：</td>
                <td><select name="goods_type" onchange="this.form.submit()" style="border:1px solid #ccc;">
                    <option value="0"><?php echo $this->_var['lang']['all_option']; ?></option>
                    
                    
                    
            <?php echo $this->html_options(array('options'=>$this->_var['goods_type_list'],'selected'=>$this->_var['goods_type_selected'])); ?>
          
                  
                  
                  </select></td>
              </tr>
              <?php endif; ?> 
              <?php if ($this->_var['goods_type_selected'] > 0): ?> 
              <?php $_from = $this->_var['goods_attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?> 
              <?php if ($this->_var['item']['type'] == 1): ?>
              <tr>
                <td><?php echo $this->_var['item']['attr']; ?>：</td>
                <td colspan="3"><input name="attr[<?php echo $this->_var['item']['id']; ?>]" value="<?php echo $this->_var['item']['value']; ?>" class="inputBg" type="text" size="20" maxlength="120" /></td>
              </tr>
              <?php endif; ?> 
              <?php if ($this->_var['item']['type'] == 2): ?>
              <tr>
                <td><?php echo $this->_var['item']['attr']; ?>：</td>
                <td colspan="3"><input name="attr[<?php echo $this->_var['item']['id']; ?>][from]" class="inputBg" value="<?php echo $this->_var['item']['value']['from']; ?>" type="text" size="5" maxlength="5" />
                  -
                  <input name="attr[<?php echo $this->_var['item']['id']; ?>][to]" value="<?php echo $this->_var['item']['value']['to']; ?>"  class="inputBg" type="text" maxlength="5" /></td>
              </tr>
              <?php endif; ?> 
              <?php if ($this->_var['item']['type'] == 3): ?>
              <tr>
                <td><?php echo $this->_var['item']['attr']; ?>：</td>
                <td colspan="3"><select name="attr[<?php echo $this->_var['item']['id']; ?>]" style="border:1px solid #ccc;">
                    <option value="0"><?php echo $this->_var['lang']['all_option']; ?></option>
                    
                    
                    
            <?php echo $this->html_options(array('options'=>$this->_var['item']['options'],'selected'=>$this->_var['item']['value'])); ?>
          
                  
                  
                  </select></td>
              </tr>
              <?php endif; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
              <?php endif; ?> 
              
              <?php if ($this->_var['use_storage'] == 1): ?>
              <tr>
                <td>&nbsp;</td>
                <td><label for="outstock"><input type="checkbox" name="outstock" value="1" id="outstock" <?php if ($this->_var['outstock']): ?>checked="checked"<?php endif; ?>/> <?php echo $this->_var['lang']['hidden_outstock']; ?></label></td>
              </tr>
              <?php endif; ?>
              
              <tr>
                <td colspan="4" align="center"><input type="hidden" name="action" value="form" />
                  <input type="submit" name="Submit" class="bnt_blue_1" value="<?php echo $this->_var['lang']['button_search']; ?>" /></td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
    <div class="blank5"></div>
    <?php endif; ?> 
    
    <?php if (isset ( $this->_var['goods_list'] )): ?>
    <div class="box">
      <div class="box_1">
        <h3> 
           
          <?php if ($this->_var['intromode'] == 'best'): ?> 
          <span><?php echo $this->_var['lang']['best_goods']; ?></span> 
          <?php elseif ($this->_var['intromode'] == 'new'): ?> 
          <span><?php echo $this->_var['lang']['new_goods']; ?></span> 
          <?php elseif ($this->_var['intromode'] == 'hot'): ?> 
          <span><?php echo $this->_var['lang']['hot_goods']; ?></span> 
          <?php elseif ($this->_var['intromode'] == 'promotion'): ?> 
          <span><?php echo $this->_var['lang']['promotion_goods']; ?></span> 
          <?php else: ?> 
          <span><?php echo $this->_var['lang']['search_result']; ?></span> 
          <?php endif; ?> 
          <?php if ($this->_var['goods_list']): ?>
          <form action="search.php" method="post" class="sort" name="listform" id="form">
            <?php echo $this->_var['lang']['btn_display']; ?>： <a href="javascript:;" onClick="javascript:display_mode('list')"><img src="themes/default/images/display_mode_list<?php if ($this->_var['pager']['display'] == 'list'): ?>_act<?php endif; ?>.gif" alt="<?php echo $this->_var['lang']['display']['list']; ?>"></a> <a href="javascript:;" onClick="javascript:display_mode('grid')"><img src="themes/default/images/display_mode_grid<?php if ($this->_var['pager']['display'] == 'grid'): ?>_act<?php endif; ?>.gif" alt="<?php echo $this->_var['lang']['display']['grid']; ?>"></a> <a href="javascript:;" onClick="javascript:display_mode('text')"><img src="themes/default/images/display_mode_text<?php if ($this->_var['pager']['display'] == 'text'): ?>_act<?php endif; ?>.gif" alt="<?php echo $this->_var['lang']['display']['text']; ?>"></a>&nbsp;&nbsp;
            <select name="sort">
              
              
              
              <?php echo $this->html_options(array('options'=>$this->_var['lang']['sort'],'selected'=>$this->_var['pager']['search']['sort'])); ?>
              
            
            
            </select>
            <select name="order">
              
              
              
              <?php echo $this->html_options(array('options'=>$this->_var['lang']['order'],'selected'=>$this->_var['pager']['search']['order'])); ?>
              
            
            
            </select>
            <input type="image" name="imageField" src="themes/default/images/bnt_go.gif" alt="go"/>
            <input type="hidden" name="page" value="<?php echo $this->_var['pager']['page']; ?>" />
            <input type="hidden" name="display" value="<?php echo $this->_var['pager']['display']; ?>" id="display" />
            <?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?> 
            <?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?>
            <?php if ($this->_var['key'] == 'keywords'): ?>
            <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo urldecode($this->_var['item']); ?>" />
            <?php else: ?>
            <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['item']; ?>" />
            <?php endif; ?>
            <?php endif; ?> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </form>
          <?php endif; ?> 
        </h3>
        <?php if ($this->_var['goods_list']): ?>
        <div class="result_filter" style="height:170px;">
        <style>
		.line_in_box{
			cursor:pointer;
			margin-left:10px;
			height:27px;
			line-height:27px;
			width:360px;
			padding-left:20px;
			margin-top:10px;
			background:url(themes/default/images/t-bg.png) no-repeat right center;
			border:2px solid #EEE;
		}
		.outer_selector_box{
			display:block;
			background:#FFF;
			z-index:999;
			border:1px solid #39F;
			position:absolute;
		}
		.bigger_box{
			width:400px;
			margin-left:100px;
			margin-top:30px;
		}
		.smaller_box{
			width:382px;
			margin-left:10px;
			margin-top:3px;
			padding-bottom:15px;
		}
		.smaller_box ul{
			max-height:350px;
		}
		.close_blue_img{
			float:right;
			height:30px;
			width:30px;
			border-left:1px solid #39F;
			border-bottom:1px solid #39F;
			background-image:url(themes/default/images/close_blue.png);
			cursor:pointer;
		}
		.outer_selector_box ul li{
			width:150px;
			height:20px;
			display:block;
			float:left;
			margin-left:10px;
			margin-top:5px;
			cursor:pointer;
			background-color:#EEE;
		}
		.ulSelectBox li{
			float:left;
			padding:3px 5px;
			height:20px;
			margin-left:20px;
			cursor:pointer;
		}
		.ulSelectBox li:hover{
			background-color:#F93;
			color:#FFF;
		}
        </style>
        
        <script>
		function closeSelectorBox(targetElement){
			jQuery(targetElement).closest(".outer_selector_box").css("display","none");
		}
		function openCarTypeSelectorBox(){
			jQuery("#carTypeSelectorBox").css("display","block");
		}
		function openCarBrandSelectorBox(){
			jQuery("#carBrandSelectorBox").css("display","block");
		}
		function chooseCarBrand(carBrandCatId, carBrandName, targetElement){
			jQuery("#carBrandSelectorResult").text(carBrandName);
			jQuery("#carBrandSelectorResult").attr("cat_id", carBrandCatId);
			window.currCarCategoryId=carBrandCatId;
			window.currCarCategoryName=carBrandName;
			closeSelectorBox(targetElement);
			openCarSeriesSelectorBox();
		}
		function openCarSeriesSelectorBox(){
			jQuery("#carSeriesSelectorBox ul").empty();
			jQuery("#carSeriesSelectorBox").css("display","block");
			Ajax.call( 'search.php?act=query_sub_car_series', 'cat_id=' + window.currCarCategoryId, queryCarSeriesCallBack , 'GET', 'JSON', true, true );
		}
		function queryCarSeriesCallBack(result){
			var resultLen=Object.keys(result).length;
			for(var i=0;i<resultLen;i++){
				var tmpResult="<li cat_id=\""+result[i+""]["cat_id"]+"\" onclick="+"\"chooseCarSeries("+result[i+""]["cat_id"]+", \'"+result[i+""]["cat_name"]+"\', this)\""+">"+result[i+""]["cat_name"]+"</li>";
				jQuery("#carSeriesSelectorBox").find("ul").prepend(tmpResult);
			}
		}
		function chooseCarSeries(carSeriesCatId, carSeriesName, targetElement){
			jQuery("#carSeriesSelectorResult").text(carSeriesName);
			jQuery("#carSeriesSelectorResult").attr("cat_id", carSeriesCatId);
			window.currCarCategoryId=carSeriesCatId;
			window.currCarCategoryName=window.currCarCategoryName+" "+carSeriesName;
			closeSelectorBox(targetElement);
			openCarYearSelectorBox();
		}
		function openCarYearSelectorBox(){
			jQuery("#carYearSelectorBox ul").empty();
			jQuery("#carYearSelectorBox").css("display","block");
			Ajax.call( 'search.php?act=query_sub_car_year', 'cat_id=' + window.currCarCategoryId, queryCarYearCallBack , 'GET', 'JSON', true, true );
		}
		function queryCarYearCallBack(result){
			var resultLen=Object.keys(result).length;
			for(var i=0;i<resultLen;i++){
				var oneResult="<li onclick=\"chooseCarYear(this)\""+">"+result[i+""]["cat_name"]+"</li>";
				jQuery("#carYearSelectorBox").find("ul").prepend(oneResult);
			}
		}
		function chooseCarYear(targetElement){
			jQuery("#carYearSelectorResult").text(jQuery(targetElement).text());
			closeSelectorBox(targetElement);
			openCarCapacitySelectorBox();
		}
		function openCarCapacitySelectorBox(){
			jQuery("#carCapacitySelectorBox ul").empty();
			jQuery("#carCapacitySelectorBox").css("display","block");
			//alert('cat_id=' + jQuery("#carSeriesSelectorResult").attr('cat_id')+'&carYear='+jQuery("#carYearSelectorResult").text());
			Ajax.call( 'search.php?act=query_sub_car_capacity', 'cat_id=' + window.currCarCategoryId+'&carYear='+jQuery("#carYearSelectorResult").text(), queryCarCapacityCallBack , 'GET', 'JSON', true, true );
		}
		function queryCarCapacityCallBack(result){
			var resultLen=Object.keys(result).length;
			for(var i=0;i<resultLen;i++){
				var tmpResult="<li onclick="+"\"chooseCarCapacity(this)\""+">"+result[i+""]["cat_name"]+"</li>";
				jQuery("#carCapacitySelectorBox").find("ul").prepend(tmpResult);
			}
		}
		function chooseCarCapacity(targetElement){
			jQuery("#carCapacitySelectorResult").text(jQuery(targetElement).text());
			closeSelectorBox(targetElement);
			openCarFullTypeSelectorBox();
		}
		function openCarFullTypeSelectorBox(){
			jQuery("#carFullTypeSelectorBox ul").empty();
			jQuery("#carFullTypeSelectorBox").css("display","block");
			Ajax.call( 'search.php?act=query_sub_car_types', 'cat_id=' + window.currCarCategoryId +'&carYear='+jQuery("#carYearSelectorResult").text()+'&carCapacity='+jQuery("#carCapacitySelectorResult").text(), queryCarFullTypeCallBack , 'GET', 'JSON', true, true );
		}
		function queryCarFullTypeCallBack(result){
			var resultLen=Object.keys(result).length;
			for(var i=0;i<resultLen;i++){
				var tmpResult="<li cat_id='"+result[i+""]["cat_id"]+"' style=\"width:200px\" onclick="+"\"chooseCarFullType(this)\""+">"+result[i+""]["name"]+"</li>";
				jQuery("#carFullTypeSelectorBox").find("ul").prepend(tmpResult);
			}
		}
		function chooseCarFullType(targetElement){
			window.currCarCategoryId=jQuery(targetElement).attr("cat_id");
			jQuery("#carFullTypeSelectorResult").text(jQuery(targetElement).text());
			window.currCarCategoryName=jQuery(targetElement).text();
			jQuery("#carFullTypeSelectorResult").attr("cat_id", window.currCarCategoryId);
			closeSelectorBox(targetElement);
		}
		function replaceOrInsertUrlParams(myUrl, name, val){
			var tmps=myUrl.split("?");
			var tmpStrs=tmps[1].split("&");
			var hasName=false;
			for(var i=0; i<tmpStrs.length;i++){
				var tmpPair=tmpStrs[i].split("=");
				if(tmpPair[0]==name){
					tmpStrs[i]=name+"="+val;
					hasName=true;
					break;
				}
			}
			if(hasName==false){
				var retUrl=myUrl+"&"+name+"="+val;
				return retUrl;
			}
			var retUrl=tmps[0]+"?"+tmpStrs[0];
			for(var i=1;i<tmpStrs.length;i++){
				retUrl=retUrl+"&"+tmpStrs[i];
			}
			return retUrl;
		}
		function replaceOriginalValOrInsertParams(myUrl, name, val, originalVal){
			var tmps=myUrl.split("?");
			var tmpStrs=tmps[1].split("&");
			var hasName=false;
			for(var i=0; i<tmpStrs.length;i++){
				var tmpPair=tmpStrs[i].split("=");
				if(tmpPair[0]==name && tmpPair[1]==originalVal){
					tmpStrs[i]=name+"="+val;
					hasName=true;
					break;
				}
			}
			if(hasName==false){
				return myUrl+"&"+name+"="+val;
			}
			var retUrl=tmps[0]+"?"+tmpStrs[0];
			for(var i=1;i<tmpStrs.length;i++){
				retUrl=retUrl+"&"+tmpStrs[i];
			}
			return retUrl;
		}
		function filterResultByCarType(){
			jQuery("input[name='car_category']").val(window.currCarCategoryId);
			jQuery("input[name='car_category_for_display']").val(window.currCarCategoryName);
			document.forms['listform'].submit();
		}
		function getUrlVars(){
			var vars = [], hash;  
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');  
			for(var i = 0; i < hashes.length; i++){
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		}
		function fillCarFullType(){
//			var theUndefined = undefined;
//			if(!(getUrlVars()['fullCarType']===theUndefined)){
//				jQuery("#carTypeFilterStr").text(decodeURI(getUrlVars()['fullCarType']));
//				//alert(decodeURI(getUrlVars()['fullCarType']));
//			}
			var car_category_for_display=jQuery("input[name='car_category_for_display']").val();
			if(car_category_for_display!=""){
				jQuery("#clearCarTypeFilterStr").css("display", "block");
				jQuery("#carTypeFilterStr").css("margin-left","0px");
				jQuery("#carTypeFilterStr").text(car_category_for_display);
			}
		}
		function chooseSubType(targetElement){
			jQuery("input[name='category']").val(jQuery(targetElement).attr("cat_id"));
			jQuery("input[name='category_level']").val(parseInt(jQuery("input[name='category_level']").val())+1);
			document.forms['listform'].submit();
		}
		function clearSubTypes(){
			jQuery("input[name='category']").val(0);
			jQuery("input[name='category_level']").val(0);
			document.forms['listform'].submit();
		}
		function clearCarTypeFilterStr(){
			jQuery("input[name='car_category_for_display']").val("");
			jQuery("input[name='car_category']").val(0);
			document.forms['listform'].submit();
		}
		function chooseBrand(targetElement){
			jQuery("input[name='brand']").val(jQuery(targetElement).attr("brand_id"));
			jQuery("input[name='brandName']").val(jQuery(targetElement).text());
			document.forms['listform'].submit();
		}
		function clearBrand(){
			jQuery("input[name='brand']").val(0);
			jQuery("input[name='brandName']").val(0);
			document.forms['listform'].submit();
		}
        </script>
        
          <table width="100%" border="0">
            <tr>
              <td width="15%" height="50px" style="background-color:#EBEBEB; text-align:center; font-size:14px; color:#535353;">配件车型</td>
              <td width="85%" height="50px" style="background-color:#F5F5F5"><input id="clearCarTypeFilterStr" style="float:left; margin-left:25px; height:18px; <?php if (! $this->_var['car_category_for_display']): ?>display:none;<?php endif; ?>" onclick="clearCarTypeFilterStr()" type="checkbox" checked="checked"><div id="carTypeFilterStr" style="float:left;display:block;line-height:25px;height:25px;<?php if (! $this->_var['car_category_for_display']): ?>margin-left:25px;<?php endif; ?>"><?php if ($this->_var['car_category_for_display']): ?><?php echo $this->_var['car_category_for_display']; ?><?php else: ?>尚未选择任何车型<?php endif; ?></div>
                <div style="height:25px; width:40px; background-color:#F93; color:#FFF; display:block;float:left;text-align:center; vertical-align:middle;line-height:25px; margin-left:20px; cursor:pointer;" onclick="openCarTypeSelectorBox()">选择</div>
                <div id="carTypeSelectorBox" class="outer_selector_box bigger_box" style="height:300px; display:none;">
                  <div class="close_blue_img" onclick="closeSelectorBox(this)"></div>
                  <div style="clear:both"></div>
                  <div cat_id="-1" id="carBrandSelectorResult" class="line_in_box" onclick="openCarBrandSelectorBox()">请选择汽车品牌</div>
                  <div id="carBrandSelectorBox" class="outer_selector_box smaller_box" style="display:none;">
                    <div class="close_blue_img" onclick="closeSelectorBox(this)"></div>
                    <div style="clear:both"></div>
                    <ul style="width:375px; overflow:auto;margin-top:7px;">
                    <?php $_from = $this->_var['all_car_brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_car_brand');if (count($_from)):
    foreach ($_from AS $this->_var['one_car_brand']):
?>
                    <li style="background:#efefef; cursor:pointer" cat_id="<?php echo $this->_var['one_car_brand']['cat_id']; ?>" onclick="chooseCarBrand('<?php echo $this->_var['one_car_brand']['cat_id']; ?>', '<?php echo $this->_var['one_car_brand']['cat_name']; ?>', this)"><?php echo $this->_var['one_car_brand']['first_letter']; ?>. <?php echo $this->_var['one_car_brand']['cat_name']; ?></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?><li></li></ul>
                  </div>
                  <div cat_id="-1" id="carSeriesSelectorResult" class="line_in_box" onclick="openCarSeriesSelectorBox()">请选择车系</div>
                  <div id="carSeriesSelectorBox" class="outer_selector_box smaller_box" style="display:none;">
                    <div class="close_blue_img" onclick="closeSelectorBox(this)"></div>
                    <div style="clear:both"></div>
                    <ul style="width:375px; overflow:auto;margin-top:7px;">
                    <li></li></ul>
                  </div>
                  <div id="carYearSelectorResult" class="line_in_box" onclick="openCarYearSelectorBox()">请选择年款</div>
                  <div id="carYearSelectorBox" class="outer_selector_box smaller_box" style="display:none;">
                    <div class="close_blue_img" onclick="closeSelectorBox(this)"></div>
                    <div style="clear:both"></div>
                    <ul style="width:375px; overflow:auto;margin-top:7px;">
                    <li></li></ul>
                  </div>
                  <div id="carCapacitySelectorResult" class="line_in_box" onclick="openCarCapacitySelectorBox()">请选择排量</div>
                  <div id="carCapacitySelectorBox" class="outer_selector_box smaller_box" style="display:none;">
                    <div class="close_blue_img" onclick="closeSelectorBox(this)"></div>
                    <div style="clear:both"></div>
                    <ul style="width:375px; overflow:auto;margin-top:7px;">
                    <li></li></ul>
                  </div>
                  <div id="carFullTypeSelectorResult" class="line_in_box" onclick="openCarFullTypeSelectorBox()">请选择车型</div>
                  <div id="carFullTypeSelectorBox" class="outer_selector_box smaller_box" style="display:none;">
                    <div class="close_blue_img" onclick="closeSelectorBox(this)"></div>
                    <div style="clear:both"></div>
                    <ul style="width:375px; overflow:auto; margin-top:7px;">
                    <li></li></ul>
                  </div>
                  <div style="cursor:pointer; height:30px; width:80px; text-align:center; line-height:30px; vertical-align:middle; margin-left:100px; border:2px solid #ccc; margin-top:15px; float:left;" onclick="filterResultByCarType()">确定</div>
                  <div style="cursor:pointer; height:30px; width:80px; text-align:center; line-height:30px; vertical-align:middle; margin-left:50px; border:2px solid #ccc; margin-top:15px; float:left;">重置</div>
                </div></td>
            </tr>
            <tr>
              <td height="50px" style="background-color:#EBEBEB; text-align:center; font-size:14px; color:#535353;">配件分类</td>
              <td height="55px" style="background-color:#F5F5F5"><ul class="ulSelectBox"><?php $_from = $this->_var['subCategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'oneSubCategory');if (count($_from)):
    foreach ($_from AS $this->_var['oneSubCategory']):
?><li cat_id="<?php echo $this->_var['oneSubCategory']['cat_id']; ?>" onclick="chooseSubType(this)"><?php echo $this->_var['oneSubCategory']['cat_name']; ?></li><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?><?php if ($this->_var['categoryName']): ?><li onclick="clearSubTypes()" style="color:#FFF; background:#F93; display:block;"><span style="float:left;">已选：<?php echo $this->_var['categoryName']; ?></span><i style="background:url(themes/default/images/close_white.png); width:18px; height:18px; display:block; float:left; margin-left:5px;"></i></li><?php endif; ?></ul></td>
            </tr>
            <tr>
              <td height="50px" style="background-color:#EBEBEB; text-align:center; font-size:14px; color:#535353;">配件品牌</td>
              <td height="50px" style="background-color:#F5F5F5"><ul class="ulSelectBox"><?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'oneBrand');if (count($_from)):
    foreach ($_from AS $this->_var['oneBrand']):
?><li brand_id="<?php echo $this->_var['oneBrand']['brand_id']; ?>" onclick="chooseBrand(this)"><?php echo $this->_var['oneBrand']['brand_name']; ?></li><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?><?php if ($this->_var['brandName']): ?><li onclick="clearBrand()" style="color:#FFF; background:#F93; display:block;"><span style="float:left;">已选：<?php echo $this->_var['brandName']; ?></span><i style="background:url(themes/default/images/close_white.png); width:18px; height:18px; display:block; float:left; margin-left:5px;"></i></li><?php endif; ?></ul></td>
            </tr>
          </table>
        </div>
        <form action="compare.php" method="post" name="compareForm" id="compareForm" onsubmit="return compareGoods(this);">
          <?php if ($this->_var['pager']['display'] == 'list'): ?>
          <div class="goodsList"> 
            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?> 
            <?php if ($this->_var['goods']['goods_id']): ?> 
            <ul class="clearfix bgcolor"<?php if (($this->_foreach['goods_list']['iteration'] - 1) % 2 == 0): ?>id=""<?php else: ?>id="bgcolor"<?php endif; ?>>
            <li> <br>
              <a href="javascript:;" id="compareLink" onClick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo addslashes($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>')" class="f6"><?php echo $this->_var['lang']['compare']; ?></a> </li>
            <li class="thumb"><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" /></a></li>
            <li class="goodsName"> <a href="<?php echo $this->_var['goods']['url']; ?>" class="f6"> 
              <?php if ($this->_var['goods']['goods_style_name']): ?> 
              <?php echo $this->_var['goods']['goods_style_name']; ?><br />
              <?php else: ?> 
              <?php echo $this->_var['goods']['goods_name']; ?><br />
              <?php endif; ?> 
              </a> 
              <?php if ($this->_var['goods']['goods_brief']): ?> 
              <?php echo $this->_var['lang']['goods_brief']; ?><?php echo $this->_var['goods']['goods_brief']; ?><br />
              <?php endif; ?> 
            </li>
            <li> 
              <?php if ($this->_var['show_marketprice']): ?> 
              <?php echo $this->_var['lang']['market_price']; ?><font class="market"><?php echo $this->_var['goods']['market_price']; ?></font><br />
              <?php endif; ?> 
              <?php if ($this->_var['goods']['promote_price'] != ""): ?> 
              <?php echo $this->_var['lang']['promote_price']; ?><font class="shop"><?php echo $this->_var['goods']['promote_price']; ?></font><br />
              <?php else: ?> 
              <?php echo $this->_var['lang']['shop_price']; ?><font class="shop"><?php echo $this->_var['goods']['shop_price']; ?></font><br />
              <?php endif; ?> 
            </li>
            <li class="action"> <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);" class="abg f6"><?php echo $this->_var['lang']['favourable_goods']; ?></a> <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/default/images/bnt_buy_1.gif"></a> </li>
            </ul>
            <?php endif; ?> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </div>
          <?php elseif ($this->_var['pager']['display'] == 'grid'): ?>
          <div class="centerPadd">
            <div class="clearfix goodsBox" style="border:none;"> 
              <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?> 
              <?php if ($this->_var['goods']['goods_id']): ?>
              <div class="goodsItem"> <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" class="goodsimg" /></a><br />
                <p><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['goods_name']; ?></a></p>
                <?php if ($this->_var['show_marketprice']): ?> 
                <?php echo $this->_var['lang']['market_prices']; ?><font class="market_s"><?php echo $this->_var['goods']['market_price']; ?></font><br />
                <?php endif; ?> 
                <?php if ($this->_var['goods']['promote_price'] != ""): ?> 
                <?php echo $this->_var['lang']['promote_price']; ?><font class="shop_s"><?php echo $this->_var['goods']['promote_price']; ?></font><br />
                <?php else: ?> 
                <?php echo $this->_var['lang']['shop_prices']; ?><font class="shop_s"><?php echo $this->_var['goods']['shop_price']; ?></font><br />
                <?php endif; ?> 
                <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);" class="f6"><?php echo $this->_var['lang']['btn_collect']; ?></a> | <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" class="f6"><?php echo $this->_var['lang']['btn_buy']; ?></a> | <a href="javascript:;" id="compareLink" onClick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo addslashes($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>')" class="f6"><?php echo $this->_var['lang']['compare']; ?></a> </div>
              <?php endif; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            </div>
          </div>
          <?php elseif ($this->_var['pager']['display'] == 'text'): ?>
          <div class="goodsList"> 
            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?> 
            <ul class="clearfix bgcolor"<?php if (($this->_foreach['goods_list']['iteration'] - 1) % 2 == 0): ?>id=""<?php else: ?>id="bgcolor"<?php endif; ?>>
            <li style="margin-right:15px;"> <a href="javascript:;" id="compareLink" onClick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo addslashes($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>')" class="f6"><?php echo $this->_var['lang']['compare']; ?></a> </li>
            <li class="goodsName"> <a href="<?php echo $this->_var['goods']['url']; ?>" class="f6 f5"> 
              <?php if ($this->_var['goods']['goods_style_name']): ?> 
              <?php echo $this->_var['goods']['goods_style_name']; ?><br />
              <?php else: ?> 
              <?php echo $this->_var['goods']['goods_name']; ?><br />
              <?php endif; ?> 
              </a> 
              <?php if ($this->_var['goods']['goods_brief']): ?> 
              <?php echo $this->_var['lang']['goods_brief']; ?><?php echo $this->_var['goods']['goods_brief']; ?><br />
              <?php endif; ?> 
            </li>
            <li> 
              <?php if ($this->_var['show_marketprice']): ?> 
              <?php echo $this->_var['lang']['market_price']; ?><font class="market"><?php echo $this->_var['goods']['market_price']; ?></font><br />
              <?php endif; ?> 
              <?php if ($this->_var['goods']['promote_price'] != ""): ?> 
              <?php echo $this->_var['lang']['promote_price']; ?><font class="shop"><?php echo $this->_var['goods']['promote_price']; ?></font><br />
              <?php else: ?> 
              <?php echo $this->_var['lang']['shop_price']; ?><font class="shop"><?php echo $this->_var['goods']['shop_price']; ?></font><br />
              <?php endif; ?> 
            </li>
            <li class="action"> <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);" class="abg f6"><?php echo $this->_var['lang']['favourable_goods']; ?></a> <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/default/images/bnt_buy_1.gif"></a> </li>
            </ul>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </div>
          <?php endif; ?>
        </form>
        <script type="text/javascript">
        <?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
        var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                <?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
        <?php if ($this->_var['key'] != 'button_compare'): ?>
        var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php else: ?>
        var button_compare = '';
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


        var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
        window.onload = function()
        {
          Compare.init();
          fixpng();
        }
        var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
        var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
        var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
        </script> 
        <?php else: ?>
        <div style="padding:20px 0px; text-align:center" class="f5" ><?php echo $this->_var['lang']['no_search_result']; ?></div>
        <?php endif; ?> 
      </div>
    </div>
    <div class="blank"></div>
    <?php echo $this->fetch('library/pages.lbi'); ?> 
    <?php endif; ?> 
    
  </div>
   
</div>
<div class="blank5"></div>

<div class="block">
  <div class="box">
    <div class="helpTitBg clearfix"> <?php echo $this->fetch('library/help.lbi'); ?> </div>
  </div>
</div>
<div class="blank"></div>
 
 
<?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
<div id="bottomNav" class="box">
  <div class="box_1">
    <div class="links clearfix"> 
      <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?> 
      <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <?php if ($this->_var['txt_links']): ?> 
      <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?> 
      [<a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>] 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <?php endif; ?> 
    </div>
  </div>
</div>
<?php endif; ?> 

<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
