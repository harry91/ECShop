<script type="text/javascript" language="javascript" charset="utf-8" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div class="block clearfix">
  <div class="f_l"><a href="index.php" name="top"><img src="themes/default/images/logo.gif" /></a></div>
  <div class="f_r log">
    <ul>
      <li class="userInfo"> <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?> <font id="ECS_MEMBERZONE"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </font> </li>
      <?php if ($this->_var['navigator_list']['top']): ?>
      <li id="topNav" class="clearfix"> 
        <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?> 
        <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a> 
        <?php if (! ($this->_foreach['nav_top_list']['iteration'] == $this->_foreach['nav_top_list']['total'])): ?> 
        | 
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <div class="topNavR"></div>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</div>
<div  class="blank"></div>
<div id="mainNav" class="clearfix" style="display:none;"> <a href="index.php"<?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['lang']['home']; ?><span></span></a> 
  <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?> 
  <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?> <?php if ($this->_var['nav']['active'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?><span></span></a> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
</div>

<div id="search"  class="clearfix" style="display:none;">
  <div class="keys f_l"> 
    <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
            return false;
        }
    }
    -->
    
    </script> 
    <?php if ($this->_var['searchkeywords']): ?>
    <?php echo $this->_var['lang']['hot_search']; ?> ：
    <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?> <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>"><?php echo $this->_var['val']; ?></a> <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endif; ?> </div>
  <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r"  style="_position:relative; top:5px;">
    <select name="category" id="category" class="B_input">
      <option value="0"><?php echo $this->_var['lang']['all_category']; ?></option>
      
      
      <?php echo $this->_var['category_list']; ?>
    
    
    </select>
    <input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" class="B_input" style="width:110px;"/>
    <input name="imageField" type="submit" value="" class="go" style="cursor:pointer;" />
    <a href="search.php?act=advanced_search"><?php echo $this->_var['lang']['advanced_search']; ?></a>
  </form>
</div>
 
 
<script type="text/javascript">
function onChangeSearchSelector(){
	jQuery("#searchTypeSpan").text(jQuery("option[value='" + jQuery("#searchTypeSelect").val() + "']").text());
	if(jQuery("#searchTypeSelect").val() == "OEM"){
		jQuery("#searchValue").attr("placeholder", "请输入OEM");
	}else if(jQuery("#searchTypeSelect").val() == "VIN"){
		jQuery("#searchValue").attr("placeholder", "请输入VIN");
	}else{
		jQuery("#searchValue").attr("placeholder", "请输入车型、商品名称、品牌、规格型号");
	}
}
</script>
<div id="azTopBar" class="clearfix" style="background:#484848; width:960px;">
  <div style="float:left; width:250px; height:83px; background:url(themes/default/az_images/az_logo.png) no-repeat"></div>
  <div style="float:left; width:500px; height:83px;">
    <form action="search.php" name="AzSearchGoods" method="get">
      <span id="searchTypeSpan" style="float:left; display:block; height:30px; margin-top:25px; width:75px; font-size:15px; background:url(themes/default/az_images/search_arrow.png) no-repeat; padding-left:5px; line-height:30px;">关键字</span>
      <select id="searchTypeSelect" style="float:left; border:none; height:30px; margin-top:25px; margin-left:-80px; width:80px; font-size:15px; opacity:0; background:#FFF;" onChange="onChangeSearchSelector()">
        <option value="KEYWORDS" selected="selected">关键字</option>
        <option value="VIN">VIN</option>
        <option value="OEM">OEM</option>
      </select>
      <span style="float:left; margin-top:25px; width:1px; height:30px; background:#999"></span>
      <input id="searchValue" name="searchValue" style="float:left; height:28px; border:none; margin-top:25px; width:250px; padding-left:5px;" placeholder="请输入车型、商品名称、品牌、规格型号"/>
      <input type="submit" style="height:30px; width:85px; background:#DD7715; border:none; margin-top:25px; font-size:17px; font-family:SimHei;" value="搜 索"/>
    </form>
  </div>
</div>
