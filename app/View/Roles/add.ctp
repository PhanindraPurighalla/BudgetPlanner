<!-- File: /app/View/Roles/add.ctp -->

<?php echo $this->Html->link(
'Roles',
array('controller' => 'roles', 'action' => 'index')
); ?>

<div class="roles form">
<legend><?php echo __('Add Role'); ?></legend>
<?php
echo $this->Form->create();
?>
<fieldset>
<?php
echo $this->Form->input('role_name');
echo $this->Form->input('role_desc');
?>
</fieldset>
<?php echo $this->Form->end('Save Role');
?>
</div>