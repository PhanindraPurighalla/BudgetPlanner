<!-- app/View/LtsLeaveRequests/apply.ctp -->
<?php echo $this->Html->link(
'User Home',
array('controller' => 'users', 'action' => 'view', $userId)
); ?>
<div class="apply leave form">
<?php echo $this->Form->create('LtsLeaveRequest', array('type' => 'file')); ?>
<fieldset>
<legend><?php echo __('Apply Leave'); ?></legend>
<?php echo $this->Form->input('leave_type_id', array('options' => $leaveTypesToSelectFrom));
      echo $this->Form->input('leave_start_dt');
      echo $this->Form->input('leave_end_dt');
	  if ($this->Form->isFieldError('num_leaves')) {
		echo $this->Form->error('num_leaves');
	  }
      echo $this->Form->input('num_leaves', array('type' => 'hidden'));
      echo $this->Form->input('leave_reason');
	  echo $this->Form->file('LtsLeaveRequest.submittedfile'); 	  
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>