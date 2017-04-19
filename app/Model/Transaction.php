<?php
class Transaction extends AppModel {
	var $name='Transaction';
	
	var $belongsTo = array('User'=>array('className'=>'User'), 'Category'=>array('className'=>'Category'), 'Type'=>array('className'=>'Type'), 'Frequency'=>array('className'=>'Frequency'));
	
	public $actsAs = array('Search.Searchable', 'Containable');
	
	public $filterArgs = array(
        'trans_category' => array(
            'type' => 'value',
            'field' => 'Category.id'
        ),
		'trans_type' => array(
            'type' => 'value',
            'field' => 'Type.id'
        ),
		'trans_frequency' => array(
            'type' => 'value',
            'field' => 'Frequency.id'
        ),
		'trans_owner' => array(
            'type' => 'value',
            'field' => 'user_id'
        ),
		'trans_date' => array(
            'type' => 'date',
            'field' => 'Transaction.trans_date'
        ),
		'trans_description' => array(
            'type' => 'like',
            'field' => 'trans_desc'
        ),
		'transDateGreaterThanOrEqualTo'       => array(
            'type'      => 'query',
            'method'    => 'searchTransDateGreaterThanCondition',
			'field'     => 'trans_date'
        ),
		'transDateLessThanOrEqualTo'       => array(
            'type'      => 'query',
            'method'    => 'searchTransDateLessThanCondition'
        )
    );
	
	public $validate = array(
		'trans_desc' => array(
							'rule' => 'notBlank'
							),
		'category_id' => array(
							'rule' => 'notBlank'
							),
		'type_id' => array(
							'rule' => 'notBlank'
							),
		'user_id' => array(
							'rule' => 'notBlank'
							),
		'frequency_id' => array(
							'rule' => 'notBlank'
							),	
		'trans_date' => array(
					'rule' => 'datetime',
					'message' => 'Transaction date is mandatory'
					),
		'trans_amount' => array(
							'rule' => 'notBlank'
							),
		'is_income' => array(
							'rule' => 'notBlank'
							),					
		'trans_desc' => array(
					'required' => array(
								'on'         => 'create',
								'rule' => 'checkTransactionAlreadyExists',
								'message' => 'Transaction Record already exists'
								)
					 )					 
	);
	
	/* Custom validation functions */
	public function checkTransactionAlreadyExists($data) { 
		$transaction1=new Transaction(); 
        $transaction=$transaction1->hasAny(array('trans_date'=>$this->data['Transaction']['trans_date'], 'trans_desc'=>$this->data['Transaction']['trans_desc']));
		if($transaction == "1"){
			return false;
		} else {
			return true;
		}		
    }
	
	public function searchTransactionDateGreaterThanCondition($data = array()) {
		$filter = $data['transDateGreaterThanOrEqualTo'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$trans_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
							'AND' => array(
										$this->alias . '.trans_date >=' => '' . $trans_date . ''
										)
							);
		}					
		return $conditions;
	}
	
	public function searchTransDateLessThanCondition($data = array()) {
		$filter = $data['transDateLessThanOrEqualTo'];
		$datestring = $filter['year'] . '-' .$filter['month'] . '-' . $filter['day'];
		$trans_date = date('Y-m-d', strtotime($datestring));
		$conditions = array();
		if (!empty($filter['year']) && !empty($filter['month']) && !empty($filter['day'])) {
			$conditions = array(
							'AND' => array(
										$this->alias . '.trans_date <=' => '' . $trans_date . ''
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