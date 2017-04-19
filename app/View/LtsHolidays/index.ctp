<!-- File: /app/View/LtsHolidays/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Request Holiday Management');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add Holiday',
array('controller' => 'ltsHolidays', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="Holidays form">
<?php echo $this->Form->create('LtsHoliday', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Holidays'); ?></legend>
<?php
    echo $this->Form->input('is_flexi');
    echo $this->Form->input('occasion');
	echo $this->Form->input('holidayDate', array('type'=>'date', 'empty' => true));
?>
</fieldset>
<?php echo $this->Form->end(__('Search Holidays')); ?>
</div>

<table>
<tr>
<th>Holiday Type</th>
<th>Occasion</th>
<th>Date</th>
<th>Action</th>
</tr>
<?php foreach ($ltsHolidays as $ltsHoliday): ?>
<tr>
<td><?php 	echo (($ltsHoliday['LtsHoliday']['is_flexi'] == 1) ? "Flexi" : "Holiday") ; ?></td>
<td><?php 	echo $ltsHoliday['LtsHoliday']['hol_name']; ?></td>
<td><?php 	echo $ltsHoliday['LtsHoliday']['hol_dt']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $ltsHoliday['LtsHoliday']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $ltsHoliday['LtsHoliday']['id'])
								  );
?>
</td>								  
</tr>
<?php endforeach; ?>
<?php unset($ltsHoliday); ?>
</table>



