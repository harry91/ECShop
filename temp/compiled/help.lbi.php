<?php if ($this->_var['helps']): ?>
<?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');if (count($_from)):
    foreach ($_from AS $this->_var['help_cat']):
?>
<dl>
  <dt><a href='<?php echo $this->_var['help_cat']['cat_id']; ?>' title="<?php echo $this->_var['help_cat']['cat_name']; ?>"><?php echo $this->_var['help_cat']['cat_name']; ?></a></dt>
  <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_0_02538900_1411554206');if (count($_from)):
    foreach ($_from AS $this->_var['item_0_02538900_1411554206']):
?>
  <dd><a href="<?php echo $this->_var['item_0_02538900_1411554206']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['item_0_02538900_1411554206']['title']); ?>"><?php echo $this->_var['item_0_02538900_1411554206']['short_title']; ?></a></dd>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>