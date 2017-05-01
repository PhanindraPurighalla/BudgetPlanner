<?php 
class CategoriesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg', 'RequestHandler');
	
	var $name='Categories';
	
	public $paginate = array(
        'limit' => 50,
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
                        $this->set('_serialize', array('categories'));
                        $this->response->disableCache();
		} catch (NotFoundException $e) {
        //Do something here like redirecting to first or last page.
			debug($this->request->params['paging']);
		}
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Category code'));
		}
		$category = $this->Category->findByCategoryCode($id);
		
		if (!$category) {
                    $message = "Unable to locate category with code: $id";
		}
                else {
                    $message = "Located category: " . $category['Category']['category_code'] . "";
                }
		$this->set('category', $category);
                $this->set(compact('message', 'category'));
                $this->set('_serialize', ['message', 'category']);
                $this->response->disableCache();
	}
	
	public function add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $insertedCategory = $this->Category->findByCategoryCode($this->request->data['Category']['category_code']);

                if (!$insertedCategory) {
                    $message = "Could not insert category: " . $insertedCategory['Category']['category_code'] . "";
                } else {
                    $message = "Inserted category: " . $insertedCategory['Category']['category_code'] . "";
                }                
            }
            else {
                $message = "Could not insert category: " . $this->request->data['Category']['category_code'] . "";
            }
            $this->set(compact('message', 'insertedCategory'));
            $this->set('_serialize', ['message', 'insertedCategory']);
        }
    }

    public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid category'));
		}
		$category = $this->Category->findById($id);
		if (!$category) {
                    $message = "Unable to locate category with id: $id";
		}
		$this->set('category',$category);
		
		if ($this->request->is(array('put'))) {
			$this->Category->id = $id;
			if ($this->Category->save($this->request->data)) {
                                $updatedCategory = $this->Category->findById($id);
                                
                                if (!$updatedCategory) {
                                    $message = "Could not update category: " . $category['Category']['category_code'] . "";
                                }
                                else {                                
                                    $message = "Updated category: " . $category['Category']['category_code'] . "";
                                }                                
			}
                        else {
                            $message = "Could not update category: " . $this->request->data['Category']['category_code'] . "";
                        }
                        $this->set(compact('message', 'updatedCategory'));
                        $this->set('_serialize', ['message', 'updatedCategory']);
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
                    $message = 'The category with id: $id has been deleted.';
		}
                else {
                    $message = "Unable to delete the Transaction type with id: $id ";
                }
                
                $this->set(array('message' => $message,'_serialize' => array('message')));
	}
}