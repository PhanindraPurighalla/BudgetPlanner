<?php
class LtsLeaveRequestsController extends AppController {
public $helpers = array('Html', 'Form');
public $components = array('Paginator');
	
	var $name='LtsLeaveRequests';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'LtsLeaveRequest.id' => 'desc'
		 )		 
    );
	
	public function index($user_id = null) {
		if (!$user_id ) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->LtsLeaveRequest->User->findById($user_id);
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }
		
		
		
        $this->set('user', $user);
		//$ltsLeaveRequests = $this->LtsLeaveRequest->find('all', array('conditions' => array('LtsLeaveRequest.user_id' => $user_id)));
		$this->LtsLeaveRequest->recursive = 1;
		$this->Paginator->settings = $this->paginate;
		$this->set('ltsLeaveRequests', $this->Paginator->paginate('LtsLeaveRequest', array('LtsLeaveRequest.user_id' => $user_id)));	
									
	}

	public function apply($user_id = null) {
			
		$this->loadModel('LeaveType');				
		$leaveTypes = $this->LeaveType->find('all');
		$leaveTypesToSelectFrom = array();
		
		$this->loadModel('LeaveBalance');
		$leaveBalances = $this->LeaveBalance->find('all', array('conditions' => array('LeaveBalance.user_id' => $user_id)));
		
		foreach ($leaveTypes as $leaveType): 
			$leaveTypesToSelectFrom[$leaveType['LeaveType']['leave_type']] = $leaveType['LeaveType']['leave_type'];
		endforeach; 
		unset($leaveType);
		
		$this->set('leaveTypesToSelectFrom', $leaveTypesToSelectFrom);
		$this->set('leaveBalances', $leaveBalances);
		$this->set('userId', $user_id);
		
		if ($this->request->is('post')) {
			
			$this->LtsLeaveRequest->create();
			$this->request->data['LtsLeaveRequest']['user_id'] = $user_id;
			$this->request->data['LtsLeaveRequest']['user_name'] = AuthComponent::user('username');			
			$this->request->data['LtsLeaveRequest']['leave_type'] = $this->data['LtsLeaveRequest']['leave_type_id'];
			$this->request->data['LtsLeaveRequest']['request_status'] = "S";
			if($this->request->data['LtsLeaveRequest']['leave_type_id'] == 'FLEXI'){
				$this->request->data['LtsLeaveRequest']['approval_required'] = "N";
			}else{
				$this->request->data['LtsLeaveRequest']['approval_required'] = "Y";
			}
			$this->request->data['LtsLeaveRequest']['approver_name'] = AuthComponent::user('manager');
			if ($this->LtsLeaveRequest->save($this->request->data)) {
				$data = array('id' => CakeSession::read('LeaveBalanceId'), 'leave_type_balance' => CakeSession::read('NewLeaveBalance'));
				$this->LeaveBalance->create();
				$this->LeaveBalance->save($data);
				$numOfLeaves=CakeSession::read('NumLeaves');
				CakeSession::delete('NumLeaves');
				CakeSession::delete('LeaveBalanceId');
				CakeSession::delete('NewLeaveBalance');
				$this->Session->setFlash(__('The leave request has been saved with id %s. Number of leaves applied %s', $this->LtsLeaveRequest->id, $numOfLeaves));
				return $this->redirect(array('action' => 'index', $user_id));
			}
			$this->Session->setFlash(__('The leave request could not be saved. Please, try again.'));
		}
		
	}
	
	public function modify($user_id = null, $leave_request_id = null, $action = null, $leaveReqStatus = null) {
			
		if($action == 'Cancel'){
			$this->LtsLeaveRequest->create();
			$data = array('id' => $leave_request_id, 'request_status' => 'C');
			$this->LtsLeaveRequest->save($data);
			$this->Session->setFlash(__('The leave request %s has been cancelled.', $leave_request_id));
			return $this->redirect(array('action' => 'index', $user_id));
		}	
		
	}
	
}
