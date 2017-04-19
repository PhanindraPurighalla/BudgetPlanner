<!-- File: /app/View/ltsLeaveRequest/index.ctp -->
<h1>Leave Requests for <b><?php echo h(AuthComponent::user('username')); ?></b></h1>
<?php echo $this->Html->link(
'Apply Leave',
array('controller' => 'ltsLeaveRequests', 'action' => 'apply', AuthComponent::user('id'))
); ?>

<?php echo $this->Html->link(
'User Home',
array('controller' => 'users', 'action' => 'view', AuthComponent::user('id'))
); ?>

<div class="users form">
<?php echo $this->Form->create('LtsLeaveRequest', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Leave Request'); ?></legend>
<?php
    echo $this->Form->input('type_of_leave', array('options' => $leaveTypesToSelectFrom, 'empty' => true));
	echo $this->Form->input('request_status', array('options' => $leaveStatusesToSelectFrom, 'empty' => true));
    echo $this->Form->input('leaveStartDtGreaterThanOrEqualTo', array('type'=>'date', 'empty' => true));
	echo $this->Form->input('leaveEndDtLessThanOrEqualTo', array('type'=>'date', 'empty' => true));
?>
</fieldset>
<?php echo $this->Form->end(__('Search Leave Request')); ?>
</div>


<table>
<tr>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.id', 'Request Id'); ?></th>
<th>User Name</th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_type', 'Leave Type'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_start_dt', 'Start Date'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_end_dt', 'End Date'); ?></th>
<th>Reason</th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.request_status', 'Status'); ?></th>
<th>Num of Leaves</th>
<th>Manager</th>
<th>Action</th>
</tr>
<!-- Here is where we loop through our $ltsLeaveRequests array, printing out leaves applied by the user' -->
<?php foreach ($ltsLeaveRequests as $ltsLeaveRequest): ?>
<tr>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['id']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['user_name']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LeaveBalance']['LeaveType']['leave_type'];?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_start_dt']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_end_dt']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_reason']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsStatus']['status_desc']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['num_leaves']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['approver_name']; ?></td>
<td><?php 	if($ltsLeaveRequest['LtsStatus']['status_code'] == 'D'){echo $this->Form->postLink('Modify',
										array('action' => 'modify', $ltsLeaveRequest['LtsLeaveRequest']['id']),
										array('confirm' => 'Do you wish to continue?')
										);}
			echo "\n"; 
			if($ltsLeaveRequest['LtsStatus']['status_code'] == 'S'){echo $this->Html->link('Cancel',
									array('action' => 'modify', $ltsLeaveRequest['LtsLeaveRequest']['id']),
									array('confirm' => 'Do you wish to continue?')
								  );}
								  
?>
</td>
</tr>
<?php endforeach; ?>
<?php unset($ltsLeaveRequest); ?>
</table>
<!-- Pagination settings -->
<?php 
echo $this->Paginator->counter(
    'Page {:page} of {:pages}, showing {:current} records out of
     {:count} total, starting on record {:start}, ending on {:end}'
);
echo $this->Paginator->prev(
  ' << ' . __('previous'),
  array(),
  null,
  array('class' => 'prev disabled')
);
echo $this->Paginator->numbers();
echo $this->Paginator->next(
  ' >> ' . __('next'),
  array(),
  null,
  array('class' => 'next disabled')
);
?>