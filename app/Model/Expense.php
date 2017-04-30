<?php
class Expense extends AppModel {
	var $name='Expense';
	
	var $belongsTo = array('User'=>array('className'=>'User'), 'Category'=>array('className'=>'Category'));
	
	public $actsAs = array('Search.Searchable', 'Containable');
	
	public $filterArgs = array(
        'expense_category' => array(
            'type' => 'value',
            'field' => 'Category.id'
        ),
	'expense_owner' => array(
            'type' => 'value',
            'field' => 'user_id'
        ),
	'expense_date' => array(
            'type' => 'date',
            'field' => 'Expense.expense_date'
        ),
	'expense_description' => array(
            'type' => 'like',
            'field' => 'expense_desc'
        ),
	'expenseDateGreaterThanOrEqualTo'       => array(
            'type'      => 'query',
            'method'    => 'searchExpenseDateGreaterThanCondition',
			'field'     => 'expense_date'
        ),
	'expenseDateLessThanOrEqualTo'       => array(
            'type'      => 'query',
            'method'    => 'searchExpenseDateLessThanCondition'
        )
    );
	
	public $validate = array(
		'expense_desc' => array(
							'rule' => 'notBlank'
							),
		'category_id' => array(
							'rule' => 'notBlank'
							),
		'user_id' => array(
							'rule' => 'notBlank'
							),
		'expense_date' => array(
					'rule' => 'datetime',
					'message' => 'Expense date is mandatory'
					),
		'expense_amount' => array(
							'rule' => 'notBlank'
							),
		'expense_desc' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkExpenseAlreadyExists',
								'message' => 'Expense record already exists'
								)
					 )					 
	);
	
	/* Custom validation functions */
	public function checkExpenseAlreadyExists($data) { 
		$expense1=new Expense(); 
        $expense = $expense1->hasAny(array('expense_date'=>$this->data['Expense']['expense_date'], 'expense_desc'=>$this->data['Expense']['expense_desc']));
		if($expense == "1"){
			return false;
		} else {
			return true;
		}		
    }
	
	public function searchExpenseDateGreaterThanCondition($data = array()) {
		$filter = $data['expenseDateGreaterThanOrEqualTo'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$expense_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
				'AND' => array(
					$this->alias . '.expense_date >=' => '' . $expense_date . ''
					)
				);
		}					
		return $conditions;
	}
	
	public function searchExpenseDateLessThanCondition($data = array()) {
		$filter = $data['expenseDateLessThanOrEqualTo'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$expense_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
				'AND' => array(
					$this->alias . '.expense_date <=' => '' . $expense_date . ''
					)
				);
		}					
		return $conditions;
	}
	
	public function comparisonWithField($validationFields = array(), $operator = null, $compareFieldName = '') {
		if (!isset($this->data[$this->name][$compareFieldName])) {
			return true;
            //throw new CakeException(sprintf(__('Can\'t compare to the non-existing field "%s" of model %s.'), $compareFieldName, $this->name));
        }
        $compareTo = $this->data[$this->name][$compareFieldName];
        foreach ($validationFields as $key => $value) {
            if (!Validation::comparison($value, $operator, $compareTo)) {
                return false;
            }
        }
        return true;
    }
	
}