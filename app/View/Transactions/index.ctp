<!-- File: /app/View/Transactions/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Module Configuration');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add Module',
array('controller' => 'pndbModules', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="pndbModules form">
<?php echo $this->Form->create('PndbModule', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Module'); ?></legend>
<?php
    echo $this->Form->input('module name');
?>
</fieldset>
<?php echo $this->Form->end(__('Search Module')); ?>
</div>

<table>
<tr>

<th>Module</th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $pndbModules array, printing out module info -->
<?php foreach ($pndbModules as $pndbModule): ?>
<tr>
<td><?php 	echo $pndbModule['PndbModule']['module_name']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $pndbModule['PndbModule']['id']),
										array('confirm' => 'Are you sure?')
										);
?>
</td>
<td><?php echo $pndbModule['PndbModule']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($pndbModule); ?>
</table>