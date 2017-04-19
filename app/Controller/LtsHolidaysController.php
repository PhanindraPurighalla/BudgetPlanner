<?php
App::uses('LtsHoliday', 'Model');
class LtsHolidaysController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg');
	
	var $name='LtsHolidays';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
			'LtsHoliday.hol_dt' => 'asc'
        )
    );
	public function index() {
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->LtsHoliday->parseCriteria($this->Prg->parsedParams());
			$this->LtsHoliday->recursive = -1;
			$this->set('ltsHolidays', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
			debug($this->request->params['paging']);
		
		}
	}
	

	public function admin_home() {
		
	}
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Holiday Type'));
		}
		$ltsHoliday = $this->LtsHoliday->findById($id);
		
		if (!$ltsHoliday) {
			throw new NotFoundException(__('Invalid Holiday type'));
		}
		
		$this->set('ltsHoliday', $ltsHoliday);
	}
	

	
	public function add() {
		$this->loadModel('LtsHoliday');
			
		if ($this->request->is('post')) {
			$newLtsHoliday = $this->request->data['LtsHoliday']['hol_name'];
			$newLtsHolidayDt = $this->request->data['LtsHoliday']['hol_dt'];
			$newLtsHolidayType = $this->request->data['LtsHoliday']['is_flexi'];
			
			$this->LtsHoliday->create();
			if ($this->LtsHoliday->save($this->request->data)) {
				$this->Session->setFlash(__('The new holiday has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			
			$this->Session->setFlash(__('The new holiday could not be saved. Please, try again.'));
		}
	}
	
	public function delete($id) {
		$this->request->allowMethod('post');
		$this->LtsHoliday->id = $id;
		if (!$this->LtsHoliday->exists()) {
			throw new NotFoundException(__('No such holiday exists!'));
		}
		if ($this->LtsHoliday->delete()) {
			$this->Session->setFlash(__('Holiday deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Holiday was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid holiday type'));
		}
		$ltsHoliday = $this->LtsHoliday->findById($id);
		if (!$ltsHoliday) {
			throw new NotFoundException(__('No holiday exists with this id'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->LtsHoliday->id = $id;
			if ($this->LtsHoliday->save($this->request->data)) {
				$this->Session->setFlash(__('Holiday specified has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update the specified holiday.'));
		}
		if (!$this->request->data) {
			$this->request->data = $ltsHoliday;
		}
	}
	
}
?>