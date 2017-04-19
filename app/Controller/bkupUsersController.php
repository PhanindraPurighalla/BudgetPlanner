<?php 
App::uses('LtsRole', 'Model');
class UsersController extends AppController {
	public $helpers = array('Html', 'Form');
	
	var $name='Users';
	
	public function beforeFilter() {
		parent::beforeFilter();
		// Allow users to register and logout.
		$this->Auth->allow('add','logout');
	}
	
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
	public function index() {
		$this->User->recursive = 1;
		$this->set('users', $this->paginate());
	}
	
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));

		$roleDesc = array();
		$this->loadModel('LtsRole');
		$userData = $this->User->read(null, $id);
		$ltsRole = $this->LtsRole->findByRoleCode($userData['User']['role']);	
		$this->set('roleDesc', $ltsRole['LtsRole']['role_desc']);
		
	}
	
	public function add() {
		
		$this->loadModel('LtsRole');
		$ltsRoles = $this->LtsRole->find('all');
		$rolesToSelectFrom = array();
		
		foreach ($ltsRoles as $ltsRole): 
			$rolesToSelectFrom[$ltsRole['LtsRole']['role_code']] = $ltsRole['LtsRole']['role_desc'];
		endforeach; 
		unset($ltsRole); 
		
		$this->set('rolesToSelectFrom', $rolesToSelectFrom);
		
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
		}
	}
	
	public function edit($id = null) {
	
		$this->loadModel('LtsRole');
		$ltsRoles = $this->LtsRole->find('all');
		$rolesToSelectFrom = array();
		
		foreach ($ltsRoles as $ltsRole): 
			$rolesToSelectFrom[$ltsRole['LtsRole']['role_code']] = $ltsRole['LtsRole']['role_desc'];
		endforeach; 
		unset($ltsRole); 
		
		$this->set('rolesToSelectFrom', $rolesToSelectFrom);
		
		$roleDesc = array();
		$this->loadModel('LtsRole');
		$userData = $this->User->read(null, $id);
		$ltsRole = $this->LtsRole->findByRoleCode($userData['User']['role']);	
		$this->set('roleDesc', $ltsRole['LtsRole']['role_desc']);
		
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
		} 
		else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
	}
	
	public function delete($id) {
		$this->request->allowMethod('post');
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
	
	 public function changePassword($id = null) { 
        if ($this->data) { 
            if ($this->User->save($this->data)) 
                $this->Session->setFlash('Password changed successfully'); 
            else
                $this->Session->setFlash('The password was not changed'); 
        } else { 
            $this->data = $this->User->read(null, $id); 
        } 
    }
}
?>