<!-- File: /app/View/Users/index.ctp -->
<h1>Lts Users</h1>

<?php echo $this->Html->link(
'Add User',
array('controller' => 'users', 'action' => 'add')
); ?>

<table>
<tr>
<th>Id</th>
<th>User Name</th>
<th>Role Desc</th>
<th>Address</th>
<th>Contact No</th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $users array, printing out users' info -->
<?php foreach ($users as $user): ?>
<tr>
<td><?php 	echo $user['User']['id']; ?></td>
<td><?php 	echo $user['User']['username']; ?></td>
<td><?php 	echo $this->Html->link($user['User']['role'],
									array('action' => 'view', $user['User']['id'])
								  );
?>
</td>
<td><?php 	echo $user['User']['address']; ?></td>
<td><?php 	echo $user['User']['contact_no']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $user['User']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $user['User']['id'])
								  );
			echo "  "; 
			echo $this->Html->link('Change Password',
									array('action' => 'changePassword', $user['User']['id'])
								  );					  
?>
</td>
<td><?php echo $user['User']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($user); ?>
</table>