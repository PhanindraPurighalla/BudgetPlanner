<!--File: /app/View/LtsLeaveRequests/view.ctp -->
<?php 

echo $this->Form->postLink(__('Approve'), array(
                                     'controller' => 'ltsLeaveRequests',
                                     'action' => 'edit', $ltsLeaveRequest['LtsLeaveRequest']['user_id'],                                     'approved' => '1',                                                     
                                     'approved_by' => $user_manager,
                                 ), array(
                                     'class' => 'btn btn-danger'
                                 ), __('Are you sure you want to Approve # %s?',$ltsLeaveRequest['LtsLeaveRequest']['user_id']                           ));
?>

<?php 

echo $this->Form->postLink(__('Reject'), array(
                                     'controller' => 'ltsLeaveRequests',
                                     'action' => 'edit', $ltsLeaveRequest['LtsLeaveRequest']['user_id'],                                     'approved' => '1',                                                     
                                     'approved_by' => $user_manager,
                                 ), array(
                                     'class' => 'btn btn-danger'
                                 ), __('Are you sure you want to Reject # %s?',$ltsLeaveRequest['LtsLeaveRequest']['user_id']                           ));
?>

