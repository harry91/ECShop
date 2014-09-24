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
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />
<link href="http://www.autozi.com:80/resources/common/css/jquery-ui-custom.css" rel="stylesheet" type="text/css" />
<link href="http://www.autozi.com:80/resources/common/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://www.autozi.com:80/resources/themes/new/css/header.css" />
<link rel="stylesheet" type="text/css" href="http://www.autozi.com:80/resources/themes/new/css/main.css" />
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?039d115effb1a43fa3c66e592c74aa5e";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<link href="http://www.autozi.com:80/resources/themes/default/css/theme.css" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?> <?php echo $this->fetch('library/page_sub_header.lbi'); ?>
<div class="car-brand-bg2">
  <ul class="car_brand_tab2 clearfix" >
    <?php $_from = $this->_var['allCategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_category');if (count($_from)):
    foreach ($_from AS $this->_var['one_category']):
?>
    <li > <a href="#<?php echo $this->_var['one_category']['cat_name']; ?>"><?php echo $this->_var['one_category']['cat_name']; ?></a> </li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
</div>
<div class="main clearfix" style="margin-top:10px">
  <div id="optionBarHidden" style="display:none;height:100px"> </div>
  <div class="fixture_box"> <?php $_from = $this->_var['allCategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_category');if (count($_from)):
    foreach ($_from AS $this->_var['one_category']):
?>
    <h3 class="fixture_title event-index" id="<?php echo $this->_var['one_category']['cat_name']; ?>" name="<?php echo $this->_var['one_category']['cat_name']; ?>" style="margin-top:-1px; text-align:left;"><?php echo $this->_var['one_category']['cat_name']; ?></h3>
    <div class="brand_list clearfix">
      <ul>
      <?php $_from = $this->_var['one_category']['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_brand');if (count($_from)):
    foreach ($_from AS $this->_var['one_brand']):
?>
        <li class="brand_list_item"><a href="search.php?brand=<?php echo $this->_var['one_brand']['brand_id']; ?>&brandName=<?php echo $this->_var['one_brand']['brand_name']; ?>" class="brand_logo_pic"><img src="data/brandlogo/<?php echo $this->_var['one_brand']['brand_logo']; ?>">
          <h4><?php echo $this->_var['one_brand']['brand_name']; ?></h4>
          </a>
        </li>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>