<!-- File: /app/View/LtsLeaveRequests/reject.ctp -->

<?php echo $this->Html->link(
'Pending Leave Requests',
array('controller' => 'ltsLeaveRequests', 'action' => 'reject')
); ?>

<div class="ltsLeaveRequests form">
<h1>Adding the remarks for leave request id <b><?php echo h($ltsLeaveRequest['LtsLeaveRequest']['id']); ?></b></h1>
<?php echo $this->Form->create('LtsLeaveRequest'); ?>
<fieldset>
<legend><?php echo __('Add Remarks'); ?></legend>
<?php 
echo $this->Form->input('approver_remarks');
?>
</fieldset>
<?php 
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end(__('Submit')); 
?>
</div>
