<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
	var $name='User';
	
	public $belongsTo = 'LtsRole';
	
	public $validate = array(
		'username' => array(
					'required' => array(
								'rule' => array('notEmpty'),
								'message' => 'A username is required'
								)
					 ),
		'password' => array(
					'required' => array(
								'rule' => array('notEmpty'),
								'message' => 'A password is required'
								)
					),
		'rolessss' => array(
					'valid' => array(
							'rule' => array('inList', array('admin', 'author')),
							'message' => 'Please enter a valid role',
							'allowEmpty' => false
							)
					),
		'current_password' => array( 
            'notempty' => array('rule' => 'notEmpty', 'message' => 'please enter your old password'), 
            'check password' => array('rule' => 'checkPassword', 
                'message' => 'your password is not correct') 
        )			
		);
		
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
																		$this->data[$this->alias]['password']
																	);
		}
		return true;
	}
	
	public function checkPassword($data) { 
        $user1=new User(); 
        $user=$user1->read(null,  $this->data['User']['id']); 
        //$current_password=AuthComponent::password($data['current_password']); 
        /*if($current_password==$user['User']['password']){ 
			return true; 
		} */
		
		if(crypt($data['current_password'], $user['User']['password']) == $user['User']['password']) {
			return true;
		}
        return false; 
     }
	
}
?>