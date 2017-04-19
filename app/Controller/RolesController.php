<?php 
class RolesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg');
	
	var $name='Roles';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Role.role_name' => 'asc'
        )
    );
	
	public function index() {
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Role->parseCriteria($this->Prg->parsedParams());
			$this->Role->recursive = 1;
			$this->set('roles', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
        //Do something here like redirecting to first or last page.
			debug($this->request->params['paging']);
		}
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid role'));
		}
		$role = $this->Role->findById($id);
		
		if (!$role) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->set('role', $role);
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
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
		$role = $this->Role->findById($id);
		if (!$role) {
			throw new NotFoundException(__('Invalid role'));
		}
		
		$this->Role->id = $id;
		$this->set('role', $this->Role->read(null, $id));
		
		if ($this->request->is(array('post', 'put'))) {
			$this->Role->id = $id;
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash(__('Role has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update role.'));
		}
		if (!$this->request->data) {
			$this->request->data = $role;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Role->delete($id)) {
			$this->Session->setFlash(__('The role with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}
	
}
?>