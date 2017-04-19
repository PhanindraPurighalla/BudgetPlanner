<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
	var $name='User';
	
	var $belongsTo = 'Role';
	
	public $actsAs = array('Search.Searchable','Containable');
	
	public $filterArgs = array(
        'user_name' => array(
            'type' => 'like',
            'field' => 'username'
        ),
        'user_role' => array(
            'type' => 'like',
            'field' => 'Role.role_name'
        )
    );
	
	public $hasMany = array(
        'Transaction' => array(
            'className' => 'Transaction',
			'foreignKey' => 'user_id',
			'dependent' => true
        )
    );
	
	public $validate = array(
		'username' => array(
					'required' => array(
								'rule' => array('notBlank'),
								'message' => 'A username is required'
								)
					 ),
		'username' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkUserAlreadyExists',
								'message' => 'This user already exists'
								)
					 ),			 
		'password' => array(
					'required' => array(
								'rule' => array('notBlank'),
								'message' => 'A password is required'
								)
					),
		'password1' => array(
					'required' => array(
								'rule' => array('notBlank'),
								'message' => 'Please enter your new password'
								)
					),					
		'password2' => array(
					'required' => array(
								'rule' => array('notBlank'),
								'message' => 'Please confirm your password'
								)
					),			
		'current_password' => array(
				'rule' => 'checkPassword',
				'message' => 'You entered a wrong password',
		),		
		'password2' => array(
				'rule' => 'matchPasswords',
				'message' => 'Your new passwords do not match',
		),
		'lts_role_iddsfdsf' => array(
					'valid' => array(
							'rule' => array('inList', array('admin', 'author')),
							'message' => 'Please enter a valid role',
							'allowEmpty' => false
							)
					),
		'start_dt' => array(
					'required' => array(
								'rule' => array('notBlank'),
								'message' => 'Start date is required'
								)
					),
		'start_dt' => array(
					'rule' => 'date',
					'message' => 'Please enter a valid start date'
					),			
		'end_dt' => array(
					'rule' => 'date',
					'message' => 'Please enter a valid end date'
					),								
		'end_dt' => array(
					'required' => array(
								'rule' => array('comparisonWithField', '>=', 'start_dt'),
								'message' => 'End date cannot be earlier than start date'
								)
					)				
		);
		
		
	/* Custom validation functions */
	public function checkUserAlreadyExists($data) { 
		$user1=new User(); 
        $user=$user1->hasAny(array('username'=>$this->data['User']['username']));
		if($user == "1"){
			return false;
		} else {
			return true;
		}		
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

	public function matchPasswords($data) { 
        if ($this->data['User']['password1'] == $this->data['User']['password2']) {
            return true;
		}		
        return false; 
    } 
     
    public function checkPassword($data) { 
        $user1=new User(); 
        $user=$user1->read(null,  $this->data['User']['id']); 
        if(crypt($data['current_password'], $user['User']['password']) == $user['User']['password']) {
			return true;
		}		 
        return false;  
    }	
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
																		$this->data[$this->alias]['password']
																	);
		}
		
		if (isset($this->data[$this->alias]['password1'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
																		$this->data[$this->alias]['password1']
																	);
		}
		
		return true;
	}
}