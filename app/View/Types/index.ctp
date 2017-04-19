<!-- File: /app/View/Types/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Transaction Type Configuration');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add Transaction Type',
array('controller' => 'types', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="types form">
<?php echo $this->Form->create('Type', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Transaction Type'); ?></legend>
<?php
    echo $this->Form->input('trans_type');
    echo $this->Form->input('description');
?>
</fieldset>
<?php echo $this->Form->end(__('Search Transaction Type')); ?>
</div>

<table>
<tr>

<th>Transaction Type</th>
<th>Description</th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $types array, printing out type info -->
<?php foreach ($types as $type): ?>
<tr>
<td><?php 	echo $type['Type']['type_code']; ?></td>
<td><?php 	echo $type['Type']['type_desc']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $type['Type']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $type['Type']['id'])
								  );
?>
</td>
<td><?php echo $type['Type']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($type); ?>
</table>