<!-- app/View/Transactions/add.ctp -->

<?php echo $this->Html->link(
'Transsactions',
array('controller' => 'transactions', 'action' => 'view', $user['User']['id'])
); ?>

<div class="transactions form">
<h1>Add Transaction for <b><?php echo h($user['User']['username']); ?></b></h1>
<?php echo $this->Form->create('Transaction'); ?>
<fieldset>
<legend><?php echo __('Add Transaction'); ?></legend>
<?php 
echo $this->Form->input('leave_type_id', array(
'options' => $leaveTypesToSelectFrom
));
echo $this->Form->input('leave_type_balance');
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>