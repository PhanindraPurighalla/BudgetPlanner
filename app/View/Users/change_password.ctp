<!-- File: /app/View/Users/change_password.ctp -->
<h1>Changing password for <b><?php echo h($user['User']['username'] ); ?></b></h1>

<?php echo $this->Html->link(
'Home',
array('controller' => 'users', 'action' => 'view', AuthComponent::user('id'))
); ?>

<div class="users form">
<?php echo $this->Form->create(); ?>
<fieldset>
<legend><?php echo __('Change Password'); ?></legend>
 
<?php echo $this->Form->input('id', array('type' => 'hidden'));?> 
<b><p>Change password for: <td><?php echo h($user['User']['username'] ); ?></td></b>
<?php echo $this->Form->input('current_password',array('type'=>'password'));?> 
<?php echo $this->Form->input('password1',array('label'=>'New password','type'=>'password', 'value'=>''));?> 
<?php echo $this->Form->input('password2',array('label'=>'Confirm your password','type'=>'password', 'value'=>''));?> 
</fieldset>
<?php echo $this->Form->end(__('Change password')); ?>
</div>