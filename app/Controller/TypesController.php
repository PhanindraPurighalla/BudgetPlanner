<?php 
class TypesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator', 'Search.Prg', 'RequestHandler');
	
	var $name='Types';
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Type.type_code' => 'asc'
        )
    );
	
	public function index() {
		try {
			$this->Prg->commonProcess();
			$this->Paginator->settings = $this->paginate;
			$this->Paginator->settings['conditions'] = $this->Type->parseCriteria($this->Prg->parsedParams());
			$this->Type->recursive = 1;
			$this->set('types', $this->Paginator->paginate());
                        $this->set('_serialize', array('types'));
                        $this->response->disableCache();
		} catch (NotFoundException $e) {
        //Do something here like redirecting to first or last page.
			debug($this->request->params['paging']);
		}
	}
	
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Transaction type'));
		}
		$type = $this->Type->findById($id);
		
		if (!$type) {
                    $message = "Unable to locate transaction type with id: $id";
                    //throw new NotFoundException(__('Invalid Transaction type'));
		}
                else {
                    $message = "Located transaction type: " . $type['Type']['type_code'] . "";
                }
		$this->set('type', $type);
                $this->set(compact('message', 'type'));
                $this->set('_serialize', ['message', 'type']);
                $this->response->disableCache();
	}
	
	public function add() {
        if ($this->request->is('post')) {
            $this->Type->create();
            if ($this->Type->save($this->request->data)) {
                $insertedType = $this->Type->findByTypeCode($this->request->data['Type']['type_code']);

                if (!$insertedType) {
                    $message = "Could not insert transaction type: " . $insertedType['Type']['type_code'] . "";
                } else {
                    $message = "Inserted transaction type: " . $insertedType['Type']['type_code'] . "";
                }
                $this->set(compact('message', 'insertedType'));
                $this->set('_serialize', ['message', 'insertedType']);
                //$this->Session->setFlash(__('New Transaction type has been saved.'));
                //return $this->redirect(array('action' => 'index'));
            }
            $this->set(array('message' => $message,'_serialize' => array('message')));
            //$this->Session->setFlash(__('Unable to configure new Transaction type.'));
        }
    }

    public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Transaction type'));
		}
		$type = $this->Type->findById($id);
		if (!$type) {
                    $message = "Unable to locate transaction type with id: $id";
                    //throw new NotFoundException(__('Invalid Transaction type'));
		}
		$this->set('type',$type);
		
		if ($this->request->is(array('put'))) {
			$this->Type->id = $id;
			if ($this->Type->save($this->request->data)) {
                                $updatedType = $this->Type->findById($id);
                                
                                if (!$updatedType) {
                                    $message = "Could not update transaction type: " . $type['Type']['type_code'] . "";
                                }
                                else {                                
                                    $message = "Updated transaction type: " . $type['Type']['type_code'] . "";
                                }
                                $this->set(compact('message', 'updatedType'));
                                $this->set('_serialize', ['message', 'updatedType']);
				//$this->Session->setFlash(__('Transaction type has been updated.'));
				//return $this->redirect(array('action' => 'index'));
			}
			//$this->Session->setFlash(__('Unable to update Transaction type.'));
		}
                
                if (!$this->request->data) {
			$this->request->data = $type;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Type->delete($id)) {
                    $message = 'The Transaction type with id: $id has been deleted.';
                    //$this->Session->setFlash(__('The Transaction type with id: %s has been deleted.', h($id)));
                    //return $this->redirect(array('action' => 'index'));
		}
                else {
                    $message = "Unable to delete the Transaction type with id: $id ";
                }
                
                $this->set(array('message' => $message,'_serialize' => array('message')));
	}
}