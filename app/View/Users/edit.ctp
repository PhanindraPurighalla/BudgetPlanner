<!-- File: /app/View/Users/edit.ctp -->
<?php echo $this->Html->link(
'Users',
array('controller' => 'users', 'action' => 'index')
); ?>

<div class="users form">
<?php
echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Edit User %s with current role %s', h($user['User']['username']), h($user['Role']['role_name'])); ?></legend>
<?php
echo $this->Form->input('contact_no');
/*echo $this->Form->input('lts_role_id', array(
'options' => $rolesToSelectFrom
));
*/
echo $this->Form->input('id', array('type' => 'hidden'));
?>
</fieldset>
<?php
echo $this->Form->end('Save User');
?>
</div>