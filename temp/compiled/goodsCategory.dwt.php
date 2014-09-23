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
<link href="themes/default/header.css" rel="stylesheet" type="text/css" />
<link href="themes/default/main.css" rel="stylesheet" type="text/css" />
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?039d115effb1a43fa3c66e592c74aa5e";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<link href="themes/default/theme.css" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?> <?php echo $this->fetch('library/page_sub_header.lbi'); ?> 


<div class="car-brand-bg2">
  <ul class="car_brand_tab2 clearfix" >
    <?php $_from = $this->_var['all_gd_cate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_gd_cate');if (count($_from)):
    foreach ($_from AS $this->_var['one_gd_cate']):
?>
    <li class="goods_category"> <a href="#<?php echo $this->_var['one_gd_cate']['cat_name']; ?>"><?php echo $this->_var['one_gd_cate']['cat_name']; ?></a> </li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
</div>

<style>
td ul.fixture_category.clearfix li {
	float:left;
}
</style>
<?php $_from = $this->_var['all_gd_cate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_gd_cate');$this->_foreach['gd_cates'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gd_cates']['total'] > 0):
    foreach ($_from AS $this->_var['one_gd_cate']):
        $this->_foreach['gd_cates']['iteration']++;
?>
<?php if ($this->_foreach['gd_cates']['iteration'] % 2): ?>
<div class="main clearfix" style="margin-top:10px">
  <div id="optionBarHidden" style="display:none;height:100px"> </div>
  <div class="fixture_box">
    <table class="fixture_table">
      <tr >
        <td ><ul class="fixture_category clearfix">
            <?php endif; ?>
            <li> <a name="<?php echo $this->_var['one_gd_cate']['cat_name']; ?>"></a>
              <div class="clearfix event_scroll" name="<?php echo $this->_var['one_gd_cate']['cat_name']; ?>">
                <h3><a href="search.php?category=<?php echo $this->_var['one_gd_cate']['cat_id']; ?>&category_level=1" target="_blank"><?php echo $this->_var['one_gd_cate']['cat_name']; ?></a></h3>
              </div>
              <?php $_from = $this->_var['one_gd_cate']['gd_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'one_gd_type');if (count($_from)):
    foreach ($_from AS $this->_var['one_gd_type']):
?>
              <div class="f_sub_category"> <a href="search.php?category=<?php echo $this->_var['one_gd_type']['cat_id']; ?>&category_level=2" target="_blank" ><?php echo $this->_var['one_gd_type']['cat_name']; ?></a> </div>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </li>
            <?php if ($this->_foreach['gd_cates']['iteration'] % 2 && ($this->_foreach['gd_cates']['iteration'] == $this->_foreach['gd_cates']['total']) == FALSE): ?>
            <?php else: ?>
          </ul></td>
      </tr>
    </table>
  </div>
</div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
 
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
