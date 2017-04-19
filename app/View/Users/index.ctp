<!-- File: /app/View/Users/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'User Configuration');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add User',
array('controller' => 'users', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="users form">
<?php echo $this->Form->create('User', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search User'); ?></legend>
<?php
    echo $this->Form->input('user_name');
    echo $this->Form->input('user_role', array('type' => 'text'));
?>
</fieldset>
<?php echo $this->Form->end(__('Search User')); ?>
</div>

<table>
<tr>
<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
<th>User Name</th>
<th><?php echo $this->Paginator->sort('Role.roleName', 'Role Desc'); ?></th>
<th>Contact No</th>
<th>Action</th>
<th>Created</th>
</tr>

<!-- Here is where we loop through our $users array, printing out users' info -->
<?php foreach ($users as $user): ?>
<tr>
<td><?php 	echo $user['User']['id']; ?></td>
<td><?php 	echo $user['User']['username']; ?></td>
<td><?php 	echo $user['Role']['role_name'];?></td>
<td><?php 	echo $user['User']['contact_no']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $user['User']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "\n"; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $user['User']['id'])
								  );
			echo "\n"; 
			echo $this->Html->link('Change password',
									array('action' => 'change_password', $user['User']['id'])
								  );
			echo "\n"; 
			echo $this->Html->link('Transactions',
									array('controller' => 'transactions', 'action' => 'view', $user['User']['id'])
								  );					  
?>
</td>
<td><?php echo $user['User']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($user); ?>
</table>
