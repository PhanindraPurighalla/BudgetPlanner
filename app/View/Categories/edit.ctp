<!-- File: /app/View/Categories/edit.ctp -->
<?php echo $this->Html->link(
'Categories',
array('controller' => 'categories', 'action' => 'index')
); ?>

<div class="categories form">
<?php
echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Edit Category %s', h($category['Category']['category_code'])); ?></legend>
<?php
echo $this->Form->input('category_desc');
echo $this->Form->input('id', array('type' => 'hidden'));
?>
</fieldset>
<?php
echo $this->Form->end('Save Category');
?>
</div>
