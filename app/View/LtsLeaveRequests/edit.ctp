<!-- app/View/LtsLeaveRequests/edit.ctp -->
<div class="ltsLeaveRequests form">
<?php echo $this->Form->create('LtsLeaveRequest'); ?>

<legend><?php echo __('Add Remarks'); ?></legend>
<?php
echo $this->Form->input('approver_remarks');
echo $this->Form->end('Save Remarks'); ?>
</div>
