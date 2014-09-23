<div class="ac w978 clearfix" style="height:60px;_overflow:hidden;font: 12px simsun; width:960px; color: #333333;display: block; margin-top:-5px; background:none;">
  <style>
  div.fl.main_nav.clearfix ul.fl.nav.clearfix li a{
	  display: block;
	  margin-left: 1px;
	  padding: 0 16px 0 16px;
	  font-size: 16px;
	  color: #fff;
	  text-decoration: none;
  }
  div.fl.main_nav.clearfix ul.fl.nav.clearfix li.act a{
	  background-image: url(themes/default/az_images/sprite.gif);
	  background-repeat: no-repeat;
	  background-position: -2px -174px;
  }
  div.fl.main_nav.clearfix ul.fl.nav.clearfix li{
	  float: left;
	  height: 50px;
	  line-height: 50px;
	  background: url(themes/default/az_images/line4.gif) no-repeat left 0;
	  overflow: hidden;
  }
  </style>
  <script>
  jQuery(document).ready(function() {
	  //var xxx=jQuery(window.location);
	  if(window.location.pathname.indexOf("goodsBrand") >= 0){
		  jQuery("#sub_header_1").addClass("act");
	  }else if(window.location.pathname.indexOf("goodsCategory") >= 0){
		  jQuery("#sub_header_2").addClass("act");
	  }else if(window.location.pathname.indexOf("carBrand") >= 0){
		  jQuery("#sub_header_3").addClass("act");
	  }else{
		  jQuery("#sub_header_0").addClass("act");
	  }
  });
  </script>
  <div class="fl main_nav clearfix" style="padding-top: 10px;width: 960px;background: url(themes/default/az_images/bg10.gif) repeat-x left top;font-family: Microsoft YaHei; float:left;">
    <h2 class="fl all_categorys" style="float:left;width: 180px;height: 50px;line-height: 50px;text-align: center;background-image: url(themes/default/az_images/sprite.gif);background-repeat: no-repeat;width: 180px;height: 50px;line-height: 50px;text-align: center;background-position: 0 -86px;font-weight: normal;"><a href="http://www.autozi.com:80/carBrandLetter/.html" style="font-size: 16px;color: #fff;text-decoration: none;">全部车型品牌</a></h2>
    <ul class="fl nav clearfix" id="headerNav" style="width: 779px;height: 50px;background: url(themes/default/az_images/bg9.gif) repeat-x;float:left">
      <li id="sub_header_0"><a href="index.php">&nbsp;&nbsp;&nbsp;首页&nbsp;&nbsp;&nbsp;</a></li>
      <li id="sub_header_1"><a href="goodsBrand.php">配件品牌</a></li>
      <li id="sub_header_2"><a href="goodsCategory.php">配件分类</a></li>
      <li id="sub_header_3"><a href="carBrand.php">汽车品牌</a></li>
    </ul>
    <a href="#" target="_blank" class="fl book_service" style="display:none;">汽车服务网</a> </div>
</div>
