<?php

//App::uses('Model');

class ExpensesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Paginator', 'Search.Prg', 'RequestHandler');
    var $name = 'Expenses';
    public $paginate = array(
        'limit' => 50,
        'order' => array(
            'Expenses.expense_date' => 'desc'
        )
    );

    public function index() {
        try {
            $this->Prg->commonProcess();
            $this->Paginator->settings = $this->paginate;
            $this->Paginator->settings['conditions'] = $this->Expense->parseCriteria($this->Prg->parsedParams());
            $this->Expense->recursive = 1;
            $this->set('expenses', $this->Paginator->paginate());
            $this->set('_serialize', array('expenses'));
            $this->response->disableCache();
        } catch (NotFoundException $e) {
            //Do something here like redirecting to first or last page.
            debug($this->request->params['paging']);
        }
    }

    public function view($id = null) {
        if (!$id) {
			throw new NotFoundException(__('Invalid expense description'));
		}
		$expense = $this->User->findByExpenseDesc($id);
		
		if (!$expense) {
                    $response = array([
                            'result' => false,
                            'code' => 'expense_not_found',
                            'message' => "Unable to locate expense with description: $id" 
                    ]);                    
		}
                else {
                    $response = array([
                            'result' => true,
                            'code' => 'located_expense',
                            'message' => "Located expense: " . $expense['Expense']['expense_desc'] . "" 
                    ]);
                }
		$this->set('expense', $expense);
                $this->set(compact('response', 'expense'));
                $this->set('_serialize', ['response', 'expense']);
                $this->response->disableCache();        
    }

    public function add() {
        $insertedExpense = '';
        $response = '';

        if ($this->request->is('post')) {
            
            $this->Expense->create();
            if ($this->Expense->save($this->request->data)) {
                $insertedExpense = $this->Expense->findByExpenseDesc($this->request->data['expense_desc']);

                if (!$insertedExpense) {
                    $response = array([
                            'result' => false,
                            'code' => 'insert_expense_error',
                            'message' => 'Could not create expense record: ' . $this->request->data['expense_desc'] 
                    ]);
            
                } else {
                    $response = array([
                            'result' => true,
                            'code' => 'insert_expense_successful',
                            'message' => 'Successfully created expense record for: ' . $this->request->data['expense_desc'] 
                    ]);
                }
            }
            else {
                $response = array([
                            'result' => false,
                            'code' => 'insert_expense_error',
                            'message' => 'Could not create expense record: ' . $this->request->data['expense_desc'] 
                    ]);
            }

            $this->set(compact('insertedExpense', 'response'));
            $this->set('_serialize', ['insertedExpense', 'response']);
        }
    }

    public function edit($id = null) {
        if (!$id) {
			throw new NotFoundException(__('Invalid expense description'));
		}
		$expense = $this->Expense->findByExpenseDesc($id);
		if (!$expense) {
                    $message = "Unable to locate expense with description: $id";
		}
		$this->set('expense',$expense);
		
		if ($this->request->is(array('put'))) {
			$this->Expense->id = $expense['Expense']['id'];
			if ($this->Expense->save($this->request->data)) {
                                $updatedExpense = $this->Expense->findById($expense['Expense']['id']);
                                
                                if (!$updatedExpense) {
                                    $message = "Could not update expense record for description: " . $id . "";
                                }
                                else {                                
                                    $message = "Updated expense record for description: " . $id . "";
                                }
                                $this->set(compact('message', 'updatedExpense'));
                                $this->set('_serialize', ['message', 'updatedExpense']);
			}
		}
                
                if (!$this->request->data) {
			$this->request->data = $expense;
		}
        
    }

    public function delete($id) {
        $this->request->allowMethod('post', 'delete');
        $expense = $this->Expense->findByExpenseDesc($id);
        if (!$expense) {
            $response = array([
                    'result' => false,
                    'code' => 'expense_not_found',
                    'message' => "Unable to locate expense with description: $id" 
            ]);
	}
        else {
            $this->set('expense',$expense);

            $this->Expense->id = $expense['Expense']['id'];		
            if ($this->Expense->delete()) {
                $response = array([
                    'result' => true,
                    'code' => 'expense_deleted',
                    'message' => "Deleted expense record having description: " . $id . "" 
                ]);
            }
            else {
                $response = array([
                    'result' => false,
                    'code' => 'expense_deletion_error',
                    'message' => "Could not delete expense record having description: " . $id . ""
                ]);
            }
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }  
}