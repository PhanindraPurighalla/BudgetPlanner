<!-- app/View/Users/add.ctp -->

<?php echo $this->Html->link(
'Users',
array('controller' => 'users', 'action' => 'index')
); ?>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
<fieldset>
<legend><?php echo __('Add User'); ?></legend>
<?php echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('contact_no');
echo $this->Form->input('role_id', array(
'options' => $rolesToSelectFrom
));
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>