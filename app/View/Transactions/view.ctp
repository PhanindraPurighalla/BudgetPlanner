<!-- File: /app/View/Transactions/view.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Transaction details');

$this->start('navbar');
?>

<li>
<?php echo $this->Html->link(
'User Home',
array('controller' => 'users', 'action' => 'view', $user['User']['id'])
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Add Transaction record',
array('controller' => 'transactions', 'action' => 'recordTransaction', $user['User']['id'])
); ?>
</li>
<?php $this->end(); ?>

<div class="users form">
<?php echo $this->Form->create('Transaction', array('type'=>'get','url' => array('page'=>'1'), 'action' => 'view/'.$user['User']['id'].'/'));?>
<fieldset>
<legend><?php echo __('Search Transaction record'); ?></legend>
<?php
    echo $this->Form->input('trans_type', array('options' => $typesToSelectFrom, 'empty' => 'Select Transaction Type'));
    echo $this->Form->input('trans_category', array('options' => $categoriesToSelectFrom, 'empty' => 'Select Transaction Category'));
	echo $this->Form->input('trans_frequency', array('options' => $frequenciesToSelectFrom, 'empty' => 'Select Frequency'));
	echo $this->Form->input('trans_desc');
	echo $this->Form->input('trans_date');
?>
</fieldset>
<?php echo $this->Form->end(__('Search Transaction record')); ?>
</div>

<?php 
if ($loggedInUser['Role']['role_name'] != 'ADMIN') {
echo $this->Html->link(
'Add Transaction record',
array('controller' => 'transactions', 'action' => 'add', $user['User']['id'])
);
}
?>

<h1>Transactions related to <b><?php echo h($user['User']['username']); ?></b></h1>

<table>
<tr>
<th><?php echo $this->Paginator->sort('Transaction.trans_date', 'Transaction Date'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.trans_desc', 'Transaction Description'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.category_id', 'Category'); ?></th>
<th>Type</th>
<th>Frequency</th>
<th>Amount</th>
<th>Action</th>
</tr>
<!-- Here is where we loop through our $transactions array, printing out Transaction info -->
<?php foreach ($transactions as $transaction): ?>
<tr>
<td><?php 	echo $transaction['Transaction']['trans_date']; ?></td>
<td><?php 	echo $transaction['Transaction']['trans_desc']; ?></td>
<td><?php 	echo $transaction['Category']['category_code']; ?></td>
<td><?php 	echo $transaction['Type']['type_code']; ?></td>
<td><?php 	echo $transaction['Frequency']['frequency_code']; ?></td>
<td><?php 	echo $transaction['Transaction']['trans_amount']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $user['User']['id'], $transaction['Transaction']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'editTransaction', $user['User']['id'], $transaction['Transaction']['id'])
								  );			
?>
</td>
</tr>
<?php endforeach; ?>
<?php unset($transaction); ?>
</table>