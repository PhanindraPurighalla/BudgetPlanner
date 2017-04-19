<!-- File: /app/View/LtsLeaveRequests/reports.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Reports');
?>

<div class="users form">
<?php echo $this->Form->create('LtsLeaveRequest', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Leave Request'); ?></legend>
<?php
    echo $this->Form->input('raised_by');
	echo $this->Form->input('type_of_leave', array('options' => $leaveTypesToSelectFrom));
    echo $this->Form->input('approver');
    echo $this->Form->input('leaveStartDtGreaterThanOrEqualTo', array('type'=>'date'));
	echo $this->Form->input('leaveEndDtLessThanOrEqualTo', array('type'=>'date'));
?>
</fieldset>
<?php echo $this->Form->end(__('Search Leave Request')); ?>
</div>

<table>
<tr>
<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.user_name', 'Raised By'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_type', 'Type of Leave'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.approver_name', 'Approver'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_start_dt', 'Leave Start'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_end_dt', 'Leave End'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.created', 'Created Date'); ?></th>
</tr>

<!-- Here is where we loop through our $ltsLeaveRequests array, printing out the results -->
<?php foreach ($ltsLeaveRequests as $ltsLeaveRequest): ?>
<tr>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['id']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['user_name']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_type'];?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['approver_name']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_start_dt']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_end_dt']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($ltsLeaveRequest); ?>
</table>
