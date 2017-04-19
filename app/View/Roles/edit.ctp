<!-- File: /app/View/Roles/edit.ctp -->
<?php echo $this->Html->link(
'Leave Types',
array('controller' => 'roles', 'action' => 'index')
); ?>

<div class="roles form">
<?php
echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Edit Role %s', h($role['Role']['role_name'])); ?></legend>
<?php
echo $this->Form->input('role_desc');
echo $this->Form->input('id', array('type' => 'hidden'));
?>
</fieldset>
<?php
echo $this->Form->end('Save Role');
?>
</div>
