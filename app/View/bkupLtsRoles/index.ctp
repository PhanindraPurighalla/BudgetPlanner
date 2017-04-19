<!-- File: /app/View/LtsRoles/index.ctp -->
<h1>Lts Roles</h1>

<?php echo $this->Html->link(
'Add Role',
array('controller' => 'ltsRoles', 'action' => 'add')
); ?>

<table>
<tr>
<th>Id</th>
<th>Role Code</th>
<th>Role Desc</th>
<th>Remarks</th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $ltsroles array, printing out roles info -->
<?php foreach ($ltsRoles as $ltsRole): ?>
<tr>
<td><?php 	echo $ltsRole['LtsRole']['id']; ?></td>
<td><?php 	echo $ltsRole['LtsRole']['role_code']; ?></td>
<td><?php 	echo $ltsRole['LtsRole']['role_desc']; ?></td>
<td><?php 	echo $ltsRole['LtsRole']['remarks']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $ltsRole['LtsRole']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $ltsRole['LtsRole']['id'])
								  );
?>
</td>
<td><?php echo $ltsRole['LtsRole']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($ltsRole); ?>
</table>