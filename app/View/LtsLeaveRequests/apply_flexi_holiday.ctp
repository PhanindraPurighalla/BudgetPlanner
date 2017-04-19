<!-- app/View/LtsLeaveRequests/apply_flexi_holiday.ctp -->
<?php echo $this->Html->link(
'View Leave Balances',
array('controller' => 'leaveBalances', 'action' => 'view', AuthComponent::user('id'))
); ?>

<div class="apply flexi holiday form">
<?php echo $this->Form->create('LtsLeaveRequest'); ?>
<fieldset>
<legend><?php echo __('Apply Flexi Holiday'); ?></legend>
<?php echo $this->Form->input('lts_holiday_id', array('options' => $flexiHolidaysToSelectFrom));
      echo $this->Form->input('leave_start_dt', array('type' => 'hidden'));
      echo $this->Form->input('leave_end_dt', array('type' => 'hidden'));
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>