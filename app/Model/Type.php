<?php
class Type extends AppModel {
	var $name='Type';
	
	public $actsAs = array('Search.Searchable', 'Containable');
	
	public $filterArgs = array(
        'trans_type' => array(
            'type' => 'like',
            'field' => 'type_code'
        ),
        'description' => array(
            'type' => 'like',
            'field' => 'type_desc'
        )
    );
	
	public $validate = array(
		'type_code' => array(
		'rule' => 'notBlank'
		),
		'type_desc' => array(
		'rule' => 'notBlank'
		),
		'type_code' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkTypeAlreadyExists',
								'message' => 'This Transaction type is already configured'
								)
					 )	
	);
	
	/* Custom validation functions */
	public function checkTypeAlreadyExists($data) { 
		$type1=new Type(); 
        $type=$type1->hasAny(array('type_code'=>$this->data['Type']['type_code']));
		if($type == "1"){
			return true;
		} else {
			return true;
		}		
    }
	
}
?>