<?php
class Role extends AppModel {
	var $name = 'Role';
	
	public $actsAs = array('Search.Searchable','Containable');
	
	public $filterArgs = array(
        'user_role' => array(
            'type' => 'like',
            'field' => 'role_name'
        ),
        'description' => array(
            'type' => 'like',
            'field' => 'role_desc'
        )
    );
	
	public $hasMany = array(
        'User' => array(
            'className' => 'User',
			'foreignKey' => 'role_id',
			'dependent' => true
        )
    );
	
	public $validate = array(
		'role_name' => array(
		'rule' => 'notEmpty'
		),
		'role_desc' => array(
		'rule' => 'notEmpty'
		),
		'role_name' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkRoleAlreadyExists',
								'message' => 'This role is already configured'
								)
					 )	
	);
	
	/* Custom validation functions */
	public function checkRoleAlreadyExists($data) { 
		$role1=new Role(); 
        $role=$role1->hasAny(array('role_name'=>$this->data['Role']['role_name']));
		if($role == "1"){
			return false;
		} else {
			return true;
		}		
    }
	
}
?>