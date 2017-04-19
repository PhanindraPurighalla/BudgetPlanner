<?php
class Category extends AppModel {
	var $name='Category';
	
	public $actsAs = array('Search.Searchable', 'Containable');
	
	var $hasMany = 'Transaction';	
	
	public $filterArgs = array(
        'transaction_category' => array(
            'type' => 'like',
            'field' => 'category_code'
        ),
        'description' => array(
            'type' => 'like',
            'field' => 'category_desc'
        )
    );
	
	
	public $validate = array(
		'category_code' => array(
		'rule' => 'notEmpty'
		),
		'category_desc' => array(
		'rule' => 'notEmpty'
		),
		'category_code' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkCategoryAlreadyExists',
								'message' => 'This category is already configured'
								)
					 )	
	);
	
	/* Custom validation functions */
	public function checkCategoryAlreadyExists($data) { 
		$category1=new Category(); 
        $category=$category1->hasAny(array('category_code'=>$this->data['Category']['category_code']));
		if($category == "1"){
			return false;
		} else {
			return true;
		}		
    }
	
}