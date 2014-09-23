<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.11.1.js')); ?>
<style>
.indexCategory h3 {
	height: 62px;
	background: url(themes/default/az_images/bg30.gif) repeat-x;
	;
	text-align: left;
}

.indexCategory h3 span {
	background: none;
	color: #000;
	font-family: Microsoft YaHei, simsun;
	font-size: 16px;
	font-weight: normal;
	clear: both;
	float: none;
	text-align: left;
	padding-left: 0px;
}

.indexCategory h3 a, #menuTitle a {
	text-decoration: none;
	color: #909090;
	margin-right: 4px;
}

.indexCategory h3 a:hover, #menuTitle a:hover {
	color: #fb5e01;
	text-decoration:underline;
}

.indexCategory h3 p {
	display: block;
	height: 25px;
	margin-top: -5px;
}

.indexCategory h3 span i {
	float: right;
	margin: 12px 0px 0 0;
	width: 5px;
	height: 9px;
	background: url(themes/default/az_images/arrow2.gif) no-repeat;
}
.brandHover.active, .brandHover.active h3 {
	background: #ffcd98;
}
</style>
<script type="text/javascript">
function hoverCategory(targetElement){
	jQuery(targetElement).addClass("active");
}
function unhoverCategory(targetElement){
	jQuery(targetElement).removeClass("active");
}
</script>
<div class="indexCategory" id="indexCategory" style="height:415px; border:1px solid #ffcd98; background:#feedd3;">
  <div>
    <dl id="menuBar">
      <dd class="brandHover" onMouseOver="hoverCategory(this)" onMouseOut="unhoverCategory(this)">
        <h3 class=""> <span><i></i>中国车型配件</span>
          <p> <a href="http://www.autozi.com:80/carBrandLetter/52.html">奇瑞</a> <a href="http://www.autozi.com:80/carBrandLetter/17.html">吉利</a> <a href="http://www.autozi.com:80/carBrandLetter/18.html">长城</a> <a href="http://www.autozi.com:80/carBrandLetter/63.html">比亚迪</a> </p>
        </h3>
      </dd>
      <dd class="brandHover" onMouseOver="hoverCategory(this)" onMouseOut="unhoverCategory(this)">
        <h3 class=""> <span><i></i>德国车型配件</span>
          <p> <a href="http://www.autozi.com:80/carBrandLetter/78.html">大众</a> <a href="http://www.autozi.com:80/carBrandLetter/64.html">奥迪</a> <a href="http://www.autozi.com:80/carBrandLetter/73.html">宝马</a> <a href="http://www.autozi.com:80/carBrandLetter/45.html">奔驰</a> </p>
        </h3>
      </dd>
      <dd class="brandHover" onMouseOver="hoverCategory(this)" onMouseOut="unhoverCategory(this)">
        <h3> <span><i></i>美国车型配件</span>
          <p> <a href="http://www.autozi.com:80/carBrandLetter/72.html">别克</a> <a href="http://www.autozi.com:80/carBrandLetter/70.html">雪佛兰</a> <a href="http://www.autozi.com:80/carBrandLetter/9.html">福特</a> <a href="http://www.autozi.com:80/carBrandLetter/71.html">克莱斯勒</a> </p>
        </h3>
      </dd>
      <dd class="brandHover" onMouseOver="hoverCategory(this)" onMouseOut="unhoverCategory(this)">
        <h3 class=""> <span><i></i>日本车型配件</span>
          <p> <a href="http://www.autozi.com:80/carBrandLetter/37.html">丰田</a> <a href="http://www.autozi.com:80/carBrandLetter/76.html">本田</a> <a href="http://www.autozi.com:80/carBrandLetter/54.html">日产</a> <a href="http://www.autozi.com:80/carBrandLetter/66.html">铃木</a> </p>
        </h3>
      </dd>
      <dd class="brandHover" onMouseOver="hoverCategory(this)" onMouseOut="unhoverCategory(this)">
        <h3 class=""> <span><i></i>韩国车型配件</span>
          <p> <a href="http://www.autozi.com:80/carBrandLetter/33.html">起亚</a> <a href="http://www.autozi.com:80/carBrandLetter/55.html">现代</a> <a href="http://www.autozi.com:80/carBrandLetter/34.html">双龙</a> </p>
        </h3>
      </dd>
      <dd class="brandHover" onMouseOver="hoverCategory(this)" onMouseOut="unhoverCategory(this)">
        <h3> <span><i></i>欧洲车型配件</span>
          <p> <a href="http://www.autozi.com:80/carBrandLetter/8.html">标致</a> <a href="http://www.autozi.com:80/carBrandLetter/23.html">雪铁龙</a> <a href="http://www.autozi.com:80/carBrandLetter/26.html">斯柯达</a> <a href="http://www.autozi.com:80/carBrandLetter/84.html">沃尔沃</a> </p>
        </h3>
      </dd>
    </dl>
    <strong id="menuTitle" style="background:url(themes/default/az_images/bg30.gif) repeat-x; height:40px; display:block;"><a style="font:14px/33px Microsoft YaHei,simsun; color:#fb5e01; line-height:40px; margin-left:10px;" href="http://www.autozi.com:80/carBrandLetter/.html">全部车型品牌</a></strong>
    <div class="menuList" style="top: 1px; left: 179px; display: none;">
      <dl id="menu_1">
        <dd> <a href="http://www.autozi.com:80/carBrandLetter/48.html">北京汽车</a><a href="http://www.autozi.com:80/carBrandLetter/63.html">比亚迪</a><a href="http://www.autozi.com:80/carBrandLetter/36.html">宝骏</a><a href="http://www.autozi.com:80/carBrandLetter/82.html">北汽</a><a href="http://www.autozi.com:80/carBrandLetter/19.html">昌河</a><a href="http://www.autozi.com:80/carBrandLetter/46.html">长丰</a><a href="http://www.autozi.com:80/carBrandLetter/77.html">长安</a><a href="http://www.autozi.com:80/carBrandLetter/18.html">长城</a><a href="http://www.autozi.com:80/carBrandLetter/22.html">帝豪</a><a href="http://www.autozi.com:80/carBrandLetter/12.html">东南</a><a href="http://www.autozi.com:80/carBrandLetter/2.html">东风</a><a href="http://www.autozi.com:80/carBrandLetter/11.html">福田</a><a href="http://www.autozi.com:80/carBrandLetter/47.html">广汽传祺</a><a href="http://www.autozi.com:80/carBrandLetter/20.html">黄海汽车</a><a href="http://www.autozi.com:80/carBrandLetter/38.html">汇众</a><a href="http://www.autozi.com:80/carBrandLetter/74.html">华泰</a><a href="http://www.autozi.com:80/carBrandLetter/39.html">一汽红旗</a><a href="http://www.autozi.com:80/carBrandLetter/79.html">海马</a><a href="http://www.autozi.com:80/carBrandLetter/59.html">哈飞</a><a href="http://www.autozi.com:80/carBrandLetter/3.html">华普</a><a href="http://www.autozi.com:80/carBrandLetter/69.html">金杯</a><a href="http://www.autozi.com:80/carBrandLetter/68.html">吉奥</a><a href="http://www.autozi.com:80/carBrandLetter/27.html">江淮</a><a href="http://www.autozi.com:80/carBrandLetter/17.html">吉利</a><a href="http://www.autozi.com:80/carBrandLetter/5.html">江铃</a><a href="http://www.autozi.com:80/carBrandLetter/44.html">开瑞</a><a href="http://www.autozi.com:80/carBrandLetter/41.html">力帆</a><a href="http://www.autozi.com:80/carBrandLetter/62.html">陆风</a><a href="http://www.autozi.com:80/carBrandLetter/58.html">理念</a><a href="http://www.autozi.com:80/carBrandLetter/67.html">MG</a><a href="http://www.autozi.com:80/carBrandLetter/15.html">纳智捷</a><a href="http://www.autozi.com:80/carBrandLetter/43.html">南汽</a><a href="http://www.autozi.com:80/carBrandLetter/50.html">启辰</a><a href="http://www.autozi.com:80/carBrandLetter/52.html">奇瑞</a><a href="http://www.autozi.com:80/carBrandLetter/14.html">全球鹰</a><a href="http://www.autozi.com:80/carBrandLetter/30.html">荣威</a><a href="http://www.autozi.com:80/carBrandLetter/28.html">瑞麒</a><a href="http://www.autozi.com:80/carBrandLetter/7.html">思铭</a><a href="http://www.autozi.com:80/carBrandLetter/42.html">五菱</a><a href="http://www.autozi.com:80/carBrandLetter/83.html">威麟</a><a href="http://www.autozi.com:80/carBrandLetter/13.html">夏利</a><a href="http://www.autozi.com:80/carBrandLetter/65.html">一汽</a><a href="http://www.autozi.com:80/carBrandLetter/53.html">英伦</a><a href="http://www.autozi.com:80/carBrandLetter/21.html">永源</a><a href="http://www.autozi.com:80/carBrandLetter/61.html">众泰</a><a href="http://www.autozi.com:80/carBrandLetter/60.html">郑州海马</a><a href="http://www.autozi.com:80/carBrandLetter/80.html">中华</a></dd>
      </dl>
    </div>
    <div class="menuList" style="top: 63px; left: 179px; display: none;">
      <dl id="menu_2">
        <dd> <a href="http://www.autozi.com:80/carBrandLetter/64.html">奥迪</a><a href="http://www.autozi.com:80/carBrandLetter/45.html">奔驰</a><a href="http://www.autozi.com:80/carBrandLetter/10.html">保时捷</a><a href="http://www.autozi.com:80/carBrandLetter/73.html">宝马</a><a href="http://www.autozi.com:80/carBrandLetter/78.html">大众</a><a href="http://www.autozi.com:80/carBrandLetter/75.html">迷你</a><a href="http://www.autozi.com:80/carBrandLetter/26.html">斯柯达</a><a href="http://www.autozi.com:80/carBrandLetter/49.html">西雅特</a></dd>
      </dl>
    </div>
    <div class="menuList" style="display:none;">
      <dl id="menu_3">
        <dd> <a href="http://www.autozi.com:80/carBrandLetter/72.html">别克</a><a href="http://www.autozi.com:80/carBrandLetter/51.html">道奇</a><a href="http://www.autozi.com:80/carBrandLetter/9.html">福特</a><a href="http://www.autozi.com:80/carBrandLetter/56.html">吉普</a><a href="http://www.autozi.com:80/carBrandLetter/6.html">凯迪拉克</a><a href="http://www.autozi.com:80/carBrandLetter/71.html">克莱斯勒</a><a href="http://www.autozi.com:80/carBrandLetter/31.html">欧宝</a><a href="http://www.autozi.com:80/carBrandLetter/70.html">雪佛兰</a></dd>
      </dl>
    </div>
    <div class="menuList" style="top: 187px; left: 179px; display: none;">
      <dl id="menu_4">
        <dd> <a href="http://www.autozi.com:80/carBrandLetter/76.html">本田</a><a href="http://www.autozi.com:80/carBrandLetter/37.html">丰田</a><a href="http://www.autozi.com:80/carBrandLetter/25.html">雷克萨斯</a><a href="http://www.autozi.com:80/carBrandLetter/66.html">铃木</a><a href="http://www.autozi.com:80/carBrandLetter/29.html">马自达</a><a href="http://www.autozi.com:80/carBrandLetter/32.html">讴歌</a><a href="http://www.autozi.com:80/carBrandLetter/54.html">日产</a><a href="http://www.autozi.com:80/carBrandLetter/16.html">三菱</a><a href="http://www.autozi.com:80/carBrandLetter/35.html">斯巴鲁</a><a href="http://www.autozi.com:80/carBrandLetter/40.html">英菲尼迪</a></dd>
      </dl>
    </div>
    <div class="menuList" style="top: 249px; left: 179px; display: none;">
      <dl id="menu_5">
        <dd><a href="http://www.autozi.com:80/carBrandLetter/33.html">起亚</a><a href="http://www.autozi.com:80/carBrandLetter/34.html">双龙</a><a href="http://www.autozi.com:80/carBrandLetter/55.html">现代</a></dd>
      </dl>
    </div>
    <div class="menuList" style="display:none;">
      <dl id="menu_6">
        <dd> <a href="http://www.autozi.com:80/carBrandLetter/8.html">标致</a><a href="http://www.autozi.com:80/carBrandLetter/1.html">菲亚特</a><a href="http://www.autozi.com:80/carBrandLetter/81.html">捷豹</a><a href="http://www.autozi.com:80/carBrandLetter/24.html">莲花</a><a href="http://www.autozi.com:80/carBrandLetter/85.html">雷诺</a><a href="http://www.autozi.com:80/carBrandLetter/4.html">路虎</a><a href="http://www.autozi.com:80/carBrandLetter/57.html">萨博</a><a href="http://www.autozi.com:80/carBrandLetter/84.html">沃尔沃</a><a href="http://www.autozi.com:80/carBrandLetter/23.html">雪铁龙</a></dd>
      </dl>
    </div>
  </div>
</div>
<div class="blank5"></div>
