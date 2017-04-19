<!-- File: /app/View/LtsLeaveRequests/leaves_pending_for_manager_approval.ctp -->
<?php echo $this->Html->link(
'User Home',
array('controller' => 'users', 'action' => 'view', AuthComponent::user('id'))
); ?>

<div class="users form">
<?php echo $this->Form->create('LtsLeaveRequest', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Leave Request'); ?></legend>
<?php
    echo $this->Form->input('raised_by');
	echo $this->Form->input('type_of_leave', array('options' => $leaveTypesToSelectFrom, 'empty' => true));
    echo $this->Form->input('leaveStartDtGreaterThanOrEqualTo', array('type'=>'date', 'empty' => true));
	echo $this->Form->input('leaveEndDtLessThanOrEqualTo', array('type'=>'date', 'empty' => true));
?>
</fieldset>
<?php echo $this->Form->end(__('Search Leave Request')); ?>
</div>


<table>
<caption>Leaves Pending for my approval</caption>
<tr>
<th><?php echo $this->Paginator->sort('id', 'Request ID'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.user_name', 'Raised By'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_type', 'Type of Leave'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_start_dt', 'Leave Start'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.leave_end_dt', 'Leave End'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.num_leaves', 'No Of Leaves'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.supporting_docs', 'Attachments'); ?></th>
<th><?php echo $this->Paginator->sort('LtsLeaveRequest.created', 'Created Date'); ?></th>
<th>Manager Remarks</th>
<th>Action</th>
</tr>

<!-- Here is where we loop through our $ltsLeaveRequests array, printing out the results -->
<?php foreach ($leavesPendingForManagerApproval as $ltsLeaveRequest): ?>
<tr>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['id']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['user_name']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LeaveBalance']['LeaveType']['leave_type'];?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_start_dt']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['leave_end_dt']; ?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['num_leaves']; ?></td>
<td><?php 	echo $this->Form->postLink($ltsLeaveRequest['LtsLeaveRequest']['supporting_docs'],
									array('action' => 'download_attachment', $ltsLeaveRequest['LtsLeaveRequest']['id']),
									array('confirm' => 'Continue downloading attachment?')
										);?></td>
<td><?php 	echo $ltsLeaveRequest['LtsLeaveRequest']['created']; ?></td>
<?php echo $this->Form->create('LtsLeaveRequest', array('url'=>'/ltsLeaveRequests/approve/'.$ltsLeaveRequest['LtsLeaveRequest']['id']));?>
<td>
<?php echo $this->Form->input('approver_remarks', array('label' => false, 'required' => true));?>
</td>
<td>
	<table>
		<tr>
			<td><?php echo $this->Form->input('approved', array('label' => "Approve?"));?></td>
		</tr>
		<tr>
			<td><?php echo $this->Form->end(__('Approve / Reject')); ?></td>
		</tr>
	</table>
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
