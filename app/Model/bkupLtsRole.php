<?php
class LtsRole extends AppModel {
	var $name='LtsRole';
	
	var $hasMany = 'User';
	
	public $validate = array(
		'role_code' => array(
		'rule' => 'notEmpty'
		),
		'role_desc' => array(
		'rule' => 'notEmpty'
		),
		'remarks' => array(
		'rule' => 'notEmpty'
		)
	);
}
?>