<?php 
class CategoriesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg');
	
	var $name='Categories';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Category.category_code' => 'asc'
        )
    );
	
	public function index() {
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Category->parseCriteria($this->Prg->parsedParams());
			$this->Category->recursive = 1;
			$this->set('categories', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
        //Do something here like redirecting to first or last page.
			debug($this->request->params['paging']);
		}
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid category'));
		}
		$category = $this->Category->findById($id);
		
		if (!$category) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->set('category', $category);
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('New category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to configure new category.'));
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid category'));
		}
		$category = $this->Category->findById($id);
		if (!$category) {
			throw new NotFoundException(__('Invalid category'));
		}
		
		$this->Category->id = $id;
		$this->set('category', $this->Category->read(null, $id));
		
		if ($this->request->is(array('post', 'put'))) {
			$this->Category->id = $id;
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('Category has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update category.'));
		}
		if (!$this->request->data) {
			$this->request->data = $category;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('The category with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}
	
}
?>