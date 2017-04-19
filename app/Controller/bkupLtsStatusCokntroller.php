<?php 
class LtsStatusController extends AppController {
	public $helpers = array('Html', 'Form');
	
	var $name='LtsStatus';
	
	public function index() {
		$this->set('ltsStatus', $this->LtsStatus->find('all'));
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid statuscode'));
		}
		$ltsStatus = $this->LtsStatus->findById($id);
		
		if (!$ltsStatus) {
			throw new NotFoundException(__('Invalid statuscode'));
		}
		$this->set('ltsStatus', $ltsStatus);
		$statusDesc = array();
		$this->loadModel('LtsStatus');
		$userData = $this->LtsStatus->read(null, $id);
		$ltsstatus = $this->LtsStatus->findByStatusName($userData['LtsStatus']['lts_status_id']);	
		$this->set('statusDesc', $ltsStatus['LtsStatus']['status_desc']);
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->LtsStatus->create();
			if ($this->LtsStatus->save($this->request->data)) {
				$this->Session->setFlash(__('New statuscode has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to configure new statuscode.'));
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid statuscode'));
		}
		$ltsStatus = $this->LtsStatus->findById($id);
		if (!$ltsStatus) {
			throw new NotFoundException(__('Invalid statuscode'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->LtsStatus->id = $id;
			if ($this->LtsStatus->save($this->request->data)) {
				$this->Session->setFlash(__('Status has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update statuscode.'));
		}
		if (!$this->request->data) {
			$this->request->data = $ltsStatus;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->LtsStatus->delete($id)) {
			$this->Session->setFlash(__('The statuscode with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}
	public function isAuthorized($user) {
		return true;
	}
}
?>