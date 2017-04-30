<?php

App::uses('Role', 'Model');

class UsersController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Paginator', 'Search.Prg', 'RequestHandler');
    var $name = 'Users';
    public $paginate = array(
        'limit' => 50,
        'order' => array(
            'User.username' => 'asc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to logout.
        $this->Auth->allow('logout');
    }

    public function rest_login() {
        if ($this->request->is('post')) {
            $loggedInUser = '';
            $response = '';
            
            if ($this->request->data && isset($this->request->data['email_id']) && isset($this->request->data['password'])) {
                
                $appUser = $this->User->find('all', array('conditions' =>
                    array('email_id' => $this->request->data['email_id'])
                        )
                );

                if (count($appUser) > 0) {
                    
                    if(crypt($this->request->data['password'], $appUser[0]['User']['password']) == $appUser[0]['User']['password']) {
			
                        $loggedInUser = $this->User->findById($appUser[0]['User']['id']);
                        $roleOfLoggedInUser = $loggedInUser['Role']['role_name'];
                        if ($roleOfLoggedInUser == 'ADMIN') {
                            $response = array([
                                    'result' => true,
                                    'code' => 'admin_user',
                                    'message' => 'Welcome, ADMIN'
                            ]);
                        } else {
                            $response = array([
                                    'result' => true,
                                    'code' => 'normal_user',
                                    'message' => 'Welcome, ' . $appUser[0]['User']['username']
                            ]);
                        }
                    }
                    
                    else {
                       $response = array([
                            'result' => false,
                            'code' => 'invalid_password',
                            'message' => 'Please check your password.'
                        ]); 
                    }
                } else {
                    $response = array([
                            'result' => false,
                            'code' => 'invalid_email',
                            'message' => 'Unable to locate user. Supplied email: ' . $this->request->data['email_id']
                    ]);
                }
            } else {
                $response = array([
                            'result' => false,
                            'code' => 'empty_credentials',
                            'message' => 'Email and password are required for login.' 
                    ]);
            }
            $this->set(compact('loggedInUser', 'response'));
            $this->set('_serialize', ['loggedInUser', 'response']);
        }
        else {
            $response = 'Not post...';
            $this->set('_serialize', array('response'));
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $loggedInUserId = array();
                $loggedInUserId = array($this->Auth->user('id'));

                $loggedInUser = $this->User->findById($loggedInUserId);
                $roleOfLoggedInUser = $loggedInUser['Role']['role_name'];
                if ($roleOfLoggedInUser == 'ADMIN') {
                    $this->Auth->loginAction = array('controller' => 'users', 'action' => 'admin_home');
                } else {
                    $url = array('controller' => 'users', 'action' => 'view');
                    $this->Auth->loginAction = array_merge($url, $loggedInUserId);
                }
                return $this->redirect($this->Auth->loginAction);
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }
    
    public function access_denied() {
        $loggedIn = $this->Auth->user('id');
        $response = [
            'result' => false,
            'code' => 'access_denied',
            'message' => 'Invalid credentials or access denied.'
        ];
        $this->set(compact('loggedIn', 'response'));
        $this->set('_serialize', ['loggedIn', 'response']);
    }

    public function logout() {
        if ($this->Auth->logout()) {
            $this->Session->setFlash(__('You have successfully logged out. Please re-login to access the application.'));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        } else {
            $this->Session->setFlash(__('Some sessions may still be in progress. Please close your browser and clear caches to logout from the application.'));
        }
    }

    public function admin_home() {
        
    }

    public function index() {
        try {
            $this->Prg->commonProcess();
            $this->Paginator->settings = $this->paginate;
            $this->Paginator->settings['conditions'] = $this->User->parseCriteria($this->Prg->parsedParams());
            $this->User->recursive = 1;
            $this->set('users', $this->Paginator->paginate());
            $this->set('_serialize', array('users'));
            $this->response->disableCache();
        } catch (NotFoundException $e) {
            //Do something here like redirecting to first or last page.
            debug($this->request->params['paging']);
        }
    }

    public function view($id = null) {
        /*$this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
        $this->set('loggedInUser', AuthComponent::user());
         * 
         */
        
        if (!$id) {
			throw new NotFoundException(__('Invalid email id'));
		}
		$user = $this->User->findByEmailId($id);
		
		if (!$user) {
                    $response = array([
                            'result' => false,
                            'code' => 'user_not_found',
                            'message' => "Unable to locate user with email id: $id" 
                    ]);                    
		}
                else {
                    $response = array([
                            'result' => true,
                            'code' => 'located_user',
                            'message' => "Located user: " . $user['User']['email_id'] . "" 
                    ]);
                }
		$this->set('user', $user);
                $this->set(compact('response', 'user'));
                $this->set('_serialize', ['response', 'user']);
                $this->response->disableCache();
        
    }

    public function add() {
        $insertedUser = '';
        $response = '';


        $this->loadModel('Role');
        $roles = $this->Role->find('all');
        $rolesToSelectFrom = array();

        foreach ($roles as $role):
            $rolesToSelectFrom[$role['Role']['role_name']] = $role['Role']['role_desc'];
        endforeach;
        unset($role);

        $this->set('rolesToSelectFrom', $rolesToSelectFrom);

        if ($this->request->is('post')) {
            //$selectedRole = $this->request->data['User']['role_id'];
            //$roleIdToSave = $this->Role->findById($this->request->data['User']['role_id']);
            //$this->request->data['User']['role_id'] = $roleIdToSave['Role']['id'];

            $this->User->create();
            if ($this->User->save($this->request->data)) {
                //$this->Session->setFlash(__('The user has been saved'));
                //return $this->redirect(array('action' => 'index'));
                $insertedUser = $this->User->findByUsername($this->request->data['username']);

                if (!$insertedUser) {
                    $response = array([
                            'result' => false,
                            'code' => 'signup_error',
                            'message' => 'Could not create user: ' . $this->request->data['username'] 
                    ]);
            
                } else {
                    $response = array([
                            'result' => true,
                            'code' => 'signup_successful',
                            'message' => 'Successfully created account for: ' . $this->request->data['username'] 
                    ]);
                }
            }


            $this->set(compact('insertedUser', 'response'));
            $this->set('_serialize', ['insertedUser', 'response']);

            /* if (isset($selectedRole)) {
              $this->request->data['User']['role_id'] = $selectedRole;
              }

              $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
             */
        }
    }

    public function edit($id = null) {

        /*
        $this->loadModel('Role');
        $roles = $this->Role->find('all');
        $rolesToSelectFrom = array();

        $roleDesc = array();
        $this->loadModel('Role');
        $userData = $this->User->read(null, $id);
        $role = $this->Role->findById($userData['User']['role_id']);
        $this->set('roleDesc', $role['Role']['role_desc']);

        $this->User->id = $id;
        $this->set('user', $this->User->read(null, $id));

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->User->save($this->request->data, true, array('address', 'contact_no', 'end_dt', 'modified'))) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'view', $id));
            }

            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
         * 
         */
        
        if (!$id) {
			throw new NotFoundException(__('Invalid email id'));
		}
		$user = $this->User->findByEmailId($id);
		if (!$user) {
                    $message = "Unable to locate user with email id: $id";
		}
		$this->set('user',$user);
		
		if ($this->request->is(array('put'))) {
			$this->User->id = $user['User']['id'];
			if ($this->User->save($this->request->data)) {
                                $updatedUser = $this->User->findById($user['User']['id']);
                                
                                if (!$updatedUser) {
                                    $message = "Could not update user profile for email id: " . $id . "";
                                }
                                else {                                
                                    $message = "Updated user profile for email id: " . $id . "";
                                }
                                $this->set(compact('message', 'updatedUser'));
                                $this->set('_serialize', ['message', 'updatedUser']);
				//$this->Session->setFlash(__('Transaction type has been updated.'));
				//return $this->redirect(array('action' => 'index'));
			}
			//$this->Session->setFlash(__('Unable to update Transaction type.'));
		}
                
                if (!$this->request->data) {
			$this->request->data = $user;
		}
        
    }

    public function delete($id) {
        $this->request->allowMethod('post', 'delete');
        $user = $this->User->findByEmailId($id);
        if (!$user) {
            $response = array([
                    'result' => false,
                    'code' => 'user_not_found',
                    'message' => "Unable to locate user with email id: $id" 
            ]);
	}
        else {
            $this->set('user',$user);

            $this->User->id = $user['User']['id'];		
            if ($this->User->delete()) {
                $response = array([
                    'result' => true,
                    'code' => 'user_deleted',
                    'message' => "Deleted profile of user having email id: " . $id . "" 
                ]);
                //$this->Session->setFlash(__('User deleted'));
                //return $this->redirect(array('action' => 'index'));
            }
            else {
                $response = array([
                    'result' => false,
                    'code' => 'user_deletion_error',
                    'message' => "Could not delete profile of user having email id: " . $id . ""
                ]);
            }
        }
        //$this->Session->setFlash(__('User was not deleted'));
        //return $this->redirect(array('action' => 'index'));
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    public function change_password($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));

        if ($this->data) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Password changed successfully. Please login with your new password.');
                return $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                $this->Session->setFlash('The password was not changed');
            }
        } else {
            $this->data = $this->User->read(null, $id);
        }
    }

}

