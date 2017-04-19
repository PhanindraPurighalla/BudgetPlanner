<?php
class Frequency extends AppModel {
	var $name='Frequency';
	
	//var $hasMany = 'User';
	public $actsAs = array('Search.Searchable', 'Containable');
	
	public $filterArgs = array(
        'frequency_name' => array(
            'type' => 'like',
            'field' => 'frequency_name'
        )
    );
	
	public $validate = array(
		'frequency_code' => array(
		'rule' => 'notBlank'
		),
                'frequency_name' => array(
		'rule' => 'notBlank'
		),
		'frequency_code' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkFrequencyAlreadyExists',
								'message' => 'This frequency is already configured'
								)
					 )	
	);
	
	/* Custom validation functions */
	public function checkFrequencyAlreadyExists($data) { 
		$frequency1=new Frequency(); 
        $frequency=$frequency1->hasAny(array('frequency_code'=>$this->data['Frequency']['frequency_code']));
		if($frequency == "1"){
			return false;
		} else {
			return true;
		}		
    }
	
}
?>