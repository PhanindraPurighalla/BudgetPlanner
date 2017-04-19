<?php
class PnsController extends AppController {
public $helpers = array('Html', 'Form');
public $components = array('Paginator', 'Search.Prg');
	
	var $name='Pns';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Pn.id' => 'desc'
		 )		 
    );
	
	public function reports() {
		$this->loadModel('Severity');				
		$severities = $this->Severity->find('all');
		$severitiesToSelectFrom = array();
				
		foreach ($severities as $severity): 
			$severitiesToSelectFrom[$severity['Severity']['severity_code']] = $severity['Severity']['severity_code'];
		endforeach; 
		unset($severity);
		
		$this->set('severitiesToSelectFrom', $severitiesToSelectFrom);
		
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Pn->parseCriteria($this->Prg->parsedParams());
			$this->Pn->recursive = -1;
			$this->set('pns', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
        //Do something here like redirecting to first or last page.
			debug($this->request->params['paging']);
		}
	}
	
	public function index() {
		$this->loadModel('Severity');
		$severities = $this->Severity->find('list',array('fields'=> array('Severity.severity_code')));
		$this->set('severitiesToSelectFrom', $severities);
		
		$this->loadModel('Status');				
		$statuses = $this->Status->find('list', array('fields' => array('Status.status_desc')));
		$this->set('statusesToSelectFrom', $statuses);
		
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Pn->parseCriteria($this->Prg->parsedParams());
			$this->Paginator->settings['conditions']['Pn.owner_id ='] = AuthComponent::user('id');	
			$this->Pn->recursive = 2;
			$this->set('pns', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
			debug($this->request->params['paging']);
		}		
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Pn->create();
			if ($this->Pn->save($this->request->data)) {
				$this->Session->setFlash(__('PN record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to save PN record.'));
		}
	}
	
	
}

 ?>