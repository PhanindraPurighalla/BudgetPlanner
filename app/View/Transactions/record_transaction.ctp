<!-- app/View/Transactions/record_transaction.ctp -->
<?php echo $this->Html->link(
'User Home',
array('controller' => 'users', 'action' => 'view', $userId)
); ?>
<div class="record_transaction form">
<?php echo $this->Form->create('Transaction'); ?>
<fieldset>
<legend><?php echo __('Transaction entry'); ?></legend>
<?php 
    echo $this->Form->input('user_id', array('type' => 'hidden'));
    echo $this->Form->input('trans_date');
    echo $this->Form->input('trans_desc');
    echo $this->Form->input('category_id', array('options' => $categoriesToSelectFrom));
    echo $this->Form->input('type_id', array('options' => $typesToSelectFrom));
    echo $this->Form->input('frequency_id', array('label' => "Frequency", 'options' => $frequenciesToSelectFrom));
    echo $this->Form->input('trans_amount');	  	  
?>
</fieldset>
<?php echo $this->Form->end(__('Submit Transaction record')); ?>
</div>