<?php 
class FrequenciesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg');
	
	var $name='Frequencies';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Frequency.frequency_code' => 'asc'
        )
    );
	
	public function index() {
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Frequency->parseCriteria($this->Prg->parsedParams());
			$this->Frequency->recursive = 1;
			$this->set('frequencies', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
        //Do something here like redirecting to first or last page.
			debug($this->request->params['paging']);
		}
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid frequency'));
		}
		$frequency = $this->Frequency->findById($id);
		
		if (!$frequency) {
			throw new NotFoundException(__('Invalid frequency'));
		}
		$this->set('frequency', $frequency);
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Frequency->create();
			if ($this->Frequency->save($this->request->data)) {
				$this->Session->setFlash(__('New frequency has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to configure new frequency.'));
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid frequency'));
		}
		$frequency = $this->Frequency->findById($id);
		if (!$frequency) {
			throw new NotFoundException(__('Invalid frequency'));
		}
		$this->set('frequency',$frequency);
		
		if ($this->request->is(array('post', 'put'))) {
			$this->Frequency->id = $id;
			if ($this->Frequency->save($this->request->data)) {
				$this->Session->setFlash(__('The frequency has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update frequency.'));
		}
		if (!$this->request->data) {
			$this->request->data = $frequency;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Frequency->delete($id)) {
			$this->Session->setFlash(__('The frequency with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}
}
?>