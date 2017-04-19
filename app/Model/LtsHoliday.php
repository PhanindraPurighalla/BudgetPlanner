<?php
class LtsHoliday extends AppModel {
	var $name='LtsHoliday';	
	public $actsAs = array('Search.Searchable');
	
	var $hasMany = 'LtsLeaveRequest';
	
	public $filterArgs = array(
        'occasion' => array(
            'type' => 'like',
            'field' => 'hol_name'
        ),
        'holidayDate' => array(
            'type' => 'query',
            'field' => 'hol_dt',
			'method'    => 'searchHolDt'
        ),
        'is_flexi' => array(
            'type' => 'value',
            'field' => 'is_flexi'
        )
    );
	
	public $virtualFields = array('holiday_description' => 'strftime(\'%d-%m-%Y\', hol_dt)||\'::::\'||hol_name');
	
	public $validate = array(
		'hol_name' => array(
					'required' => array(
								'rule' => array('notEmpty'),
								'message' => 'Please name your holiday!'
								)
					 ),			
		'hol_name' => array(
					'required' => array(
								'rule' => 'checkHolidayAlreadyExists',
								'message' => 'This holiday is already configured!'
								)
					 ),
		'hol_dt' => array(
					'rule' => 'date',
					'message' => 'Please enter a valid holiday date'
					),												
		);
	/* Custom validation functions */
	public function checkHolidayAlreadyExists($data) { 
		$LtsHoliday1 = new LtsHoliday(); 
        $LtsHoliday = $LtsHoliday1->hasAny(array('hol_name'=>$this->data['LtsHoliday']['hol_name']));
		if($LtsHoliday == "1"){
			return false;
		}
		$LtsHoliday = $LtsHoliday1->hasAny(array('hol_dt'=>$this->data['LtsHoliday']['hol_dt']));
		if($LtsHoliday == "1"){
			return false;
		}else {
			return true;
		}		
    }
	
	public function searchHolDt($data = array()) {
		$filter = $data['holidayDate'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$holiday_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
							'AND' => array(
										$this->alias . '.hol_dt =' => '' . $holiday_date . ''
										)
							);
		}					
		return $conditions;
	}
}
?>