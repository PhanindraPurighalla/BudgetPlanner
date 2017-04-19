<!-- File: /app/View/Roles/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Role Management');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add Role',
array('controller' => 'roles', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="roles form">
<?php echo $this->Form->create('Role', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Role'); ?></legend>
<?php
    echo $this->Form->input('user_role');
    echo $this->Form->input('description');
?>
</fieldset>
<?php echo $this->Form->end(__('Search Role')); ?>
</div>

<table>
<tr>
<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
<th><?php echo $this->Paginator->sort('role_name', 'Role Name'); ?></th>
<th><?php echo $this->Paginator->sort('role_desc', 'Role Desc'); ?></th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $roles array, printing out roles info -->
<?php foreach ($roles as $role): ?>
<tr>
<td><?php 	echo $role['Role']['id']; ?></td>
<td><?php 	echo $role['Role']['role_name']; ?></td>
<td><?php 	echo $role['Role']['role_desc']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $role['Role']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $role['Role']['id'])
								  );
?>
</td>
<td><?php echo $role['Role']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($role); ?>
</table>