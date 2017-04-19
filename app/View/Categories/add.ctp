<!-- File: /app/View/Cateories/add.ctp -->

<?php echo $this->Html->link(
'Categories',
array('controller' => 'categories', 'action' => 'index')
); ?>

<div class="categories form">
<legend><?php echo __('Add Category'); ?></legend>
<?php
echo $this->Form->create();
?>
<fieldset>
<?php
echo $this->Form->input('category_code');
echo $this->Form->input('category_desc');
?>
</fieldset>
<?php echo $this->Form->end('Save Category');
?>
</div>