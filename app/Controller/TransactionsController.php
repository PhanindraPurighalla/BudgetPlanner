<?php 
class TransactionsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg');
	
	var $name='Transactions';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Transaction.id' => 'desc'
		 )		 
    );
	
	public function index($user_id = null) {
		$this->loadModel('Transaction');
		$transactions = $this->Transaction->find('list', array('conditions' => array('Transaction.user_id' => $user_id),
																 'contain' => 'Severity.severity_code',
																 'fields' => array('Severity.severity_code')));	
		$this->set('categoriesToSelectFrom', $categories);
		
		$this->loadModel('Type');				
		$types = $this->Type->find('list', array('fields' => array('Type.type_desc')));
		$this->set('typesToSelectFrom', $types);
		
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Transaction->parseCriteria($this->Prg->parsedParams());
			$this->Paginator->settings['conditions']['Transaction.owner_id ='] = AuthComponent::user('id');	
			$this->Transaction->recursive = 2;
			debug($this->Paginator->settings);
			$this->set('transactions', $this->Paginator->paginate());
			debug($this->Paginator->paginate());
		} catch (NotFoundException $e) {
			debug($this->request->params['paging']);
		}									
	}
	
	public function view($user_id = null) {
		if (!$user_id ) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->Transaction->User->findById($user_id );
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $user);
		//$pns = $this->Pn->find('all', array('conditions' => array('Pn.user_id' => $user_id)));
		$transactions = $this->Transaction->find('all');//, array('conditions' => array('Pn.user_id' => $user_id)));
		$this->set('transactions', $transactions);
		
		$this->set('loggedInUser',AuthComponent::user());	
				
		
		$this->loadModel('Category');
		$categories = $this->Category->find('list',array('fields'=> array('Category.category_code')));
		$this->set('categoriesToSelectFrom', $categories);
		
		$this->loadModel('Type');				
		$types = $this->Type->find('list', array('fields' => array('Type.type_code')));
		$this->set('typesToSelectFrom', $types);
		
		$this->loadModel('Frequency');				
		$frequencies = $this->Frequency->find('list', array('fields' => array('Frequency.frequency_name')));
		$this->set('frequenciesToSelectFrom', $frequencies);
				
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Transaction->parseCriteria($this->Prg->parsedParams());
			//$this->Paginator->settings['conditions']['Pn.user_id ='] = AuthComponent::user('id');	
			$this->Transaction->recursive = 2;
			//debug($this->Paginator->settings);
			$this->set('transactions', $this->Paginator->paginate());
			//debug($this->Paginator->paginate());
		} catch (NotFoundException $e) {
			debug($this->request->params['paging']);
		}
		
	}

	public function recordTransaction($user_id = null) {
	
		if (!$user_id ) {
            throw new NotFoundException(__('Invalid user'));
        }
		
		$user = $this->Transaction->User->findById($user_id );
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('userId', $user['User']['id']);
		
		$this->loadModel('Category');
		$categories = $this->Category->find('all');
		$categoriesToSelectFrom = array();
		
		foreach ($categories as $category): 
			$categoriesToSelectFrom[$category['Category']['id']] = $category['Category']['category_code'];
		endforeach; 
		unset($category); 
		
		$this->set('categoriesToSelectFrom', $categoriesToSelectFrom);
		
		$this->loadModel('Type');
		$types = $this->Type->find('all');
		$typesToSelectFrom = array();
		
		foreach ($types as $type): 
			$typesToSelectFrom[$type['Type']['id']] = $type['Type']['type_code'];
		endforeach; 
		unset($type); 
		
		$this->set('typesToSelectFrom', $typesToSelectFrom);
		
		$this->loadModel('Frequency');
		$frequencies = $this->Frequency->find('all');
		$frequenciesToSelectFrom = array();
		
		foreach ($frequencies as $frequency): 
			$frequenciesToSelectFrom[$frequency['Frequency']['id']] = $frequency['Frequency']['frequency_name'];
		endforeach; 
		unset($frequency); 
		
		$this->set('frequenciesToSelectFrom', $frequenciesToSelectFrom);		
		
		if ($this->request->is('post')) {
			$this->request->data['Transaction']['user_id'] = $user_id;
			
			$selectedCategory = $this->request->data['Transaction']['category_id'];
			$categoryToSave = $this->Category->findById($selectedCategory);
			$this->request->data['Category']['category_id'] = $categoryToSave['Category']['id'];
			
			$selectedType = $this->request->data['Transaction']['type_id'];
			$typeToSave = $this->Type->findById($selectedType);
			$this->request->data['Transaction']['type_id'] = $typeToSave['Type']['id'];
			
			$selectedFrequency = $this->request->data['Transaction']['frequency_id'];
			$frequencyToSave = $this->Frequency->findById($selectedFrequency);
			$this->request->data['Transaction']['frequency_id'] = $frequencyToSave['Frequency']['id'];
			
			$this->Transaction->create();
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The Transaction record has been saved'));
				return $this->redirect(array('action' => 'view', $user['User']['id']));
			}
			
			if (isset($selectedCategory)) {
				$this->request->data['Transaction']['category_id'] = $selectedCategory;
			}
			
			if (isset($selectedType)) {
				$this->request->data['Transaction']['type_id'] = $selectedType;
			}
			
			if (isset($selectedFrequency)) {
				$this->request->data['Transaction']['frequency_id'] = $selectedFrequency;
			}
			
			$this->Session->setFlash(__('The Transaction record could not be saved. Please, try again.'));
		}
	}

	public function editTransaction($user_id = null, $id = null) {
	
		if (!$user_id ) {
            throw new NotFoundException(__('Invalid user'));
        }
		
		$user = $this->Transaction->User->findById($user_id );
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $user);
		
		$transaction = $this->Transaction->findById($id );
		if (!$transaction) {
            throw new NotFoundException(__('Invalid Transaction record'));
        }
        $this->set('transaction', $transaction);
		
		
		$this->loadModel('Category');
		$categories = $this->Category->find('all');
		$categoriesToSelectFrom = array();
		
		foreach ($categories as $category): 
			$categoriesToSelectFrom[$category['Category']['id']] = $category['Category']['category_code'];
		endforeach; 
		unset($category); 
		
		$this->set('categoriesToSelectFrom', $categoriesToSelectFrom);
		
		$this->loadModel('Type');
		$types = $this->Type->find('all');
		$typesToSelectFrom = array();
		
		foreach ($types as $type): 
			$typesToSelectFrom[$type['Type']['id']] = $type['Type']['type_code'];
		endforeach; 
		unset($type); 
		
		$this->set('typesToSelectFrom', $typesToSelectFrom);
		
		$this->loadModel('Frequency');
		$frequencies = $this->Frequency->find('all');
		$frequenciesToSelectFrom = array();
		
		foreach ($frequencies as $frequency): 
			$frequenciesToSelectFrom[$frequency['Frequency']['id']] = $frequency['Frequency']['frequency_name'];
		endforeach; 
		unset($frequency); 
		
		$this->set('frequenciesToSelectFrom', $frequenciesToSelectFrom);	

		$this->loadModel('User');
		$users = $this->User->find('all', array('conditions' => array('Role.role_name' => 'NORMAL')));
		$usersToSelectFrom = array();
		
		foreach ($users as $user): 
			$usersToSelectFrom[$user['User']['id']] = $user['User']['username'];
		endforeach; 
		unset($user); 
		
		$this->set('usersToSelectFrom', $usersToSelectFrom);		
		
		if ($this->request->is(array('post', 'put'))) {
			//$this->request->data['Pn']['user_id'] = $user_id;
			
			/*$selectedSeverity = $this->request->data['Pn']['severity_id'];
			$severityToSave = $this->Severity->findById($selectedSeverity);
			$this->request->data['Pn']['severity_id'] = $severityToSave['Severity']['id'];
			
			$selectedStatus = $this->request->data['Pn']['status_id'];
			$statusToSave = $this->Status->findById($selectedStatus);
			$this->request->data['Pn']['status_id'] = $statusToSave['Status']['id'];
			
			$selectedModule = $this->request->data['Pn']['pndb_module_id'];
			$moduleToSave = $this->PndbModule->findById($selectedModule);
			$this->request->data['Pn']['pndb_module_id'] = $moduleToSave['PndbModule']['id'];
			*/
			
			$this->request->data['Transaction']['trans_date'] = $transaction['Transaction']['trans_date'];
			$this->request->data['Transaction']['trans_desc'] = $transaction['Transaction']['trans_desc'];
			
			$this->request->data['Transaction']['id'] = $id;
			
			//debug ($this->request->data);
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The Transaction record has been saved'));
				return $this->redirect(array('action' => 'view', $user['User']['id']));
			}
			
			if (isset($selectedCategory)) {
				$this->request->data['Transaction']['category_id'] = $selectedCategory;
			}
			
			if (isset($selectedType)) {
				$this->request->data['Transaction']['type_id'] = $selectedType;
			}
			
			if (isset($selectedFrequency)) {
				$this->request->data['Transaction']['frequency_id'] = $selectedFrequency;
			}
			
			$this->Session->setFlash(__('The Transaction record could not be saved. Please, try again.'));
		}
	}

	public function delete($user_id = null, $id = null) {
		if (!$user_id ) {
            throw new NotFoundException(__('Invalid user'));
        }
		
		$user = $this->Transaction->User->findById($user_id );
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }
        		
		$this->request->allowMethod('post');
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid Transaction record'));
		}
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transaction record deleted'));
			return $this->redirect(array('action' => 'view', $user['User']['id']));
		}
		$this->Session->setFlash(__('Transaction record was not deleted'));
		return $this->redirect(array('action' => 'view', $user['User']['id']));
	}
	
}