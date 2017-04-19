<?php 
class LtsRolesController extends AppController {
	public $helpers = array('Html', 'Form');
	
	var $name='LtsRoles';
	
	public function index() {
		$this->set('ltsRoles', $this->LtsRole->find('all'));
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid role'));
		}
		$ltsRole = $this->LtsRole->findById($id);
		
		if (!$ltsRole) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->set('ltsRole', $ltsRole);
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->LtsRole->create();
			if ($this->LtsRole->save($this->request->data)) {
				$this->Session->setFlash(__('New role has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to configure new role.'));
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid role'));
		}
		$ltsRole = $this->LtsRole->findById($id);
		if (!$ltsRole) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->LtsRole->id = $id;
			if ($this->LtsRole->save($this->request->data)) {
				$this->Session->setFlash(__('Role has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update role.'));
		}
		if (!$this->request->data) {
			$this->request->data = $ltsRole;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->LtsRole->delete($id)) {
			$this->Session->setFlash(__('The role with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}
}
?>