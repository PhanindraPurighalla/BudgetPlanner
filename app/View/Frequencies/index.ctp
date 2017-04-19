<!-- File: /app/View/Frequencies/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Frequency Configuration');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add Frequency',
array('controller' => 'frequencies', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="frequencies form">
<?php echo $this->Form->create('Frequency', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Frequency'); ?></legend>
<?php
    echo $this->Form->input('frequency name');
?>
</fieldset>
<?php echo $this->Form->end(__('Search Frequency')); ?>
</div>

<table>
<tr>

<th>Frequency Code</th>
<th>Frequency Description</th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $frequencies array, printing out frequency info -->
<?php foreach ($frequencies as $frequency): ?>
<tr>
<td><?php 	echo $frequency['Frequency']['frequency_code']; ?></td>
<td><?php 	echo $frequency['Frequency']['frequency_name']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $frequency['Frequency']['id']),
										array('confirm' => 'Are you sure?')
										);
                echo "  "; 
		echo $this->Html->link('Edit',
									array('action' => 'edit', $frequency['Frequency']['id'])
								  );
?>
</td>
<td><?php echo $frequency['Frequency']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($frequency); ?>
</table>