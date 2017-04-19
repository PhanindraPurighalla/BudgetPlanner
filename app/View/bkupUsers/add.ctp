<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
<fieldset>
<legend><?php echo __('Add User'); ?></legend>
<?php echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('address');
echo $this->Form->input('contact_no');
echo $this->Form->input('role', array(
'options' => $rolesToSelectFrom
));
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>