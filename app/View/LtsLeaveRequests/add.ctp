<!-- app/View/LtsLeaveRequests/apply.ctp -->
<div class="apply leave form">
<?php echo $this->Form->create(); ?>
<fieldset>
<legend><?php echo __('Apply Leave'); ?></legend>
<?php echo $this->Form->input('user_id', array('hiddenField' => true));
	  echo $this->Form->input('leave_type_id', array('options' => $leaveTypesToSelectFrom));
      echo $this->Form->input('leave_start_dt');
      echo $this->Form->input('leave_end_dt');
      echo $this->Form->input('num_leaves');
      echo $this->Form->input('leave_reason');
	  echo $this->Form->input('request_status', array('hiddenField' => true));
	  echo $this->Form->input('approval_required', array('hiddenField' => true));
      echo $this->Form->input('approver_name', array('hiddenField' => true));
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>