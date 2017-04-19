<?php
App::uses('CakeTime', 'Utility');
App::import('model','LtsHoliday');
App::import('model','LeaveBalance');
class LtsLeaveRequest extends AppModel {
	
	var $name='LtsLeaveRequest';

	var $belongsTo = array('LtsStatus'=>array('className'=>'LtsStatus'),
						   'LeaveBalance'=>array('className'=>'LeaveBalance'),
						   'LtsHoliday'=>array('className'=>'LtsHoliday'));
	
	public $numLeaves;
	
	public $actsAs = array('Search.Searchable', 'Containable');
	
	public $filterArgs = array(
        'raised_by' => array(
            'type' => 'like',
            'field' => 'user_name'
        ),
        'type_of_leave' => array(
            'type' => 'value',
            'field' => 'LeaveBalance.leave_type_id'
        ),
		'request_status' => array(
            'type' => 'value',
            'field' => 'lts_status_id'
        ),
		'approver' => array(
            'type' => 'like',
            'field' => 'approver_name'
        ),
		'leaveStartDtGreaterThanOrEqualTo'       => array(
            'type'      => 'query',
            'method'    => 'searchLeaveStartDtCondition',
			'field'     => 'leave_start_dt'
        ),
		'leaveEndDtLessThanOrEqualTo'       => array(
            'type'      => 'query',
            'method'    => 'searchLeaveEndDtCondition'
        )
    );
			
	public $validate = array(
		'leave_start_dt' => array(
					'required' => array(
								'rule' => array('notEmpty'),
								'message' => 'Start date is required'
								)
					),
		'leave_type_id' => array(
					'required' => array(
								'rule' => array('notEmpty'),
								'message' => 'Leave Type is required'
								)
					),
		'leave_reason' => array(
		'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'Reason is required'
					)
		),
		'leave_start_dt' => array(
					'rule' => 'date',
					'message' => 'Enter a valid date please'
					),
		'leave_start_dt' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkOverlappingDates',
								'message' => 'Another leave request exists covering these start and end dates'
								)
					 ),			 				
		'leave_end_dt' => array(
					'required' => array(
								'rule' => array('notEmpty'),
								'message' => 'End date is required'
								)
					),
		'leave_end_dt' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkOverlappingDates',
								'message' => 'Another leave request exists covering these start and end dates'
								)
					 ),						
		'leave_end_dt' => array(
					'rule' => 'date',
					'message' => 'Enter a valid date please'
					),
		'leave_end_dt' => array(
					'required' => array(
								'rule' => array('comparisonWithField', '>=', 'leave_start_dt'),
								'message' => 'End date cannot be earlier than start date'
								)
					),
		'num_leaves' => array(
					'rule1' => array(
						'rule' => 'validateOtherLeaves',
						'message' => 'Number of leaves applied exceeds the leave balance',
						'last' => false
					 )
					)
		);
		
	public function isUploadedFile($params) {
		$val = array_shift($params);
		if ((isset($val['error']) && $val['error'] == 0) || (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) {
			return is_uploaded_file($val['tmp_name']);
		}
		return false;
	}	
	
	public function checkOverlappingDates($data) { 
		$leaveBalance = new LeaveBalance();
		$leaveBalanceData = $this->LeaveBalance->findByUserId(AuthComponent::user('id'));
		
		$validStatusCodes = array("S","A");
		$ltsLeaveRequest = new LtsLeaveRequest(); 
        $overlappingLeaveRequest=$ltsLeaveRequest->find('count',array('conditions' => array(
																						'leave_balance_id = ' => $leaveBalanceData['LeaveBalance']['id'],
																						'LtsStatus.status_code = ' => $validStatusCodes,
																						'OR' => array(array('leave_end_dt >= ' => $this->data['LtsLeaveRequest']['leave_start_dt'],
																											'leave_start_dt <= ' => $this->data['LtsLeaveRequest']['leave_end_dt']),
																									  array('leave_end_dt >= ' => $this->data['LtsLeaveRequest']['leave_end_dt'],
																											'leave_start_dt <= ' => $this->data['LtsLeaveRequest']['leave_start_dt'])
																								)
																							)));
		if($overlappingLeaveRequest >= "1"){
			return false;
		} else {
			return true;
		}		
    }
	
	public function searchLeaveStartDtCondition($data = array()) {
		$filter = $data['leaveStartDtGreaterThanOrEqualTo'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$leave_start_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
							'AND' => array(
										$this->alias . '.leave_start_dt >=' => '' . $leave_start_date . ''
										)
							);
		}					
		return $conditions;
	}
	
	public function searchLeaveEndDtCondition($data = array()) {
		$filter = $data['leaveEndDtLessThanOrEqualTo'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$leave_end_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
							'AND' => array(
										$this->alias . '.leave_end_dt <=' => '' . $leave_end_date . ''
										)
							);
		}					
		return $conditions;
	}
	
	public function comparisonWithField($validationFields = array(), $operator = null, $compareFieldName = '') {
		if (!isset($this->data[$this->name][$compareFieldName])) {
            throw new CakeException(sprintf(__('Can\'t compare to the non-existing field "%s" of model %s.'), $compareFieldName, $this->name));
        }
        $compareTo = $this->data[$this->name][$compareFieldName];
        foreach ($validationFields as $key => $value) {
            if (!Validation::comparison($value, $operator, $compareTo)) {
                return false;
            }
        }
        return true;
    }	
	
	public function validateOtherLeaves(){
		
		if(isset($this->data['LtsLeaveRequest']['lts_holiday_id'])) {
			$this->numLeaves = 1;
			return true;
		}
		
		$this->numLeaves = 0;
		$tempDate;
		$ltsHoliday = new LtsHoliday();
		$leaveBalance=new LeaveBalance();
		$startDate = $this->data['LtsLeaveRequest']['leave_start_dt'];
		$endDate = $this->data['LtsLeaveRequest']['leave_end_dt'];
		
		$startTimestamp = strtotime($this->data['LtsLeaveRequest']['leave_start_dt']);
		$endTimestamp = strtotime($this->data['LtsLeaveRequest']['leave_end_dt']);
		
		$ltsHoliday->recursive = -1;
		$holidays = $ltsHoliday->find('all', array('conditions' => array('is_flexi' => '0')));
				
		for($i=$startTimestamp; $i<=$endTimestamp; $i = $i+(60*60*24) ){
			if(date("N",$i) <= 5){
				$this->numLeaves = $this->numLeaves + 1;
				$tempDate = CakeTime::format($i, '%Y-%m-%d');
				foreach ($holidays as $holiday) {
					if($holiday['LtsHoliday']['hol_dt']==$tempDate ){
						$this->numLeaves = $this->numLeaves - 1;						
					}
				}
			}								
		}
		
		if ($this->numLeaves == 0) {
			return "No working day in leave date range to apply leaves";			
		}
		else {
			$this->data['LtsLeaveRequest']['num_leaves'] = $this->numLeaves;
		}
		
		$leaveBalance->recursive = -1;
		$leaveBal = $leaveBalance->find('first', array('conditions' => array('LeaveBalance.leave_type_id' => $this->data['LtsLeaveRequest']['leave_type_id'], 'LeaveBalance.user_id' => AuthComponent::user('id'))));
		
		if(!empty($leaveBal)){
			if(($this->numLeaves <= $leaveBal['LeaveBalance']['leave_type_balance'])){
				return true;
			}else{
				return false;				
			}
		}else{
			return false;
		}			
		
	}
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['num_leaves'])) {
			$this->data[$this->alias]['num_leaves'] = $this->numLeaves;
		}
		if (isset($this->data[$this->alias]['num_leaves'])) {
			$this->data[$this->alias]['num_leaves'] = $this->numLeaves;
		}		
		return true;
	}

}