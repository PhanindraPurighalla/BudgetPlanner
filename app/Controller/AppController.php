<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        //'Session',
        'Auth' => array(
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display',
                'home'
            ),
            'authenticate' => array(
                'Basic' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
            //'authorize' => array('Controller'),
            'unauthorizedRedirect' => [
                'admin' => true,
                'controller' => 'users',
                'action' => 'access_denied'
            ],
            'storage' => 'Memory'
        ),
        'Security'
    );

    public function beforeFilter() {
        
        $this->disableCache();
        
        if ($this->request->is('json') || $this->request->is('xml')) {
            $this->Auth->authenticate = [
                'Basic' => [
                    'passwordHasher' => 'Blowfish'
                ]
            ];
            
            $this->Auth->unauthorizedRedirect = [
                'admin' => false,
                'controller' => 'users',
                'action' => 'access_denied'
            ];
        }
        
        if (!empty($this->request->params['ext'])) {
            
            $this->Auth->unauthorizedRedirect['ext'] = $this->request->params['ext'];
        }

        if (in_array($this->params['controller'], array('types', 'users'))) {
            // For RESTful web service requests, we check the name of our contoller
            $this->Auth->allow();
            // this line should always be there to ensure that all rest calls are secure
            //$this->Security->requireSecure();
            $this->Security->unlockedActions = array('edit', 'delete', 'add', 'view', 'rest_login');
        } else {
            // setup out Auth
            $this->Auth->allow();
        }
        $this->Auth->allow('logout');
    }
	
	public function isAuthorized() {
		$idOfLoggedInUser = $this->Auth->user('id');
		if (!isset($idOfLoggedInUser)) {
			//$this->Session->setFlash('You may not be authorized to perform the requested action');
			return false;
		}
		
		if($this->request->params['action'] == "view" || stripos($this->request->params['controller'],"requests") !== false ) {
			return true;
		}
		
		$adminActions = array("add", "edit", "delete", "admin_home", "index");
		if (in_array($this->request->params['action'],$adminActions)) {
			$this->loadModel('User');
			$loggedInUser = $this->User->findById($idOfLoggedInUser);
				$roleOfLoggedInUser = $loggedInUser['Role']['role_name'];
				if ($roleOfLoggedInUser == 'ADMIN') {
					return true;
				}
				else {
					//$this->Session->setFlash('You need to be an administrator to perform the requested action');
					return $this->redirect($this->referer());	
				}	
		}
		
		if (!in_array($this->request->params['action'],$adminActions)) {
			$this->loadModel('User');
			$loggedInUser = $this->User->findById($idOfLoggedInUser);
				$roleOfLoggedInUser = $loggedInUser['Role']['role_name'];
				if ($roleOfLoggedInUser == 'ADMIN') {
					//$this->Session->setFlash('You are not allowed to perform user/manager actions. ', $this->request->params['action']);
					return $this->redirect($this->referer());	
				}
				else {
					return true;
				}	
		}
		
		if (stripos($this->request->params['controller'],"requests") !== false ) {
			return true;	
		}			
		
		if (isset($this->request->params['pass'][0])) {
			$idOfUserOnWhomActionIsBeingAttempted = (int) $this->request->params['pass'][0];
			$this->loadModel('User');
			$userOnWhomActionIsBeingAttempted = $this->User->findById($idOfUserOnWhomActionIsBeingAttempted);
			
			$roleOfUserOnWhomActionIsBeingAttempted = $userOnWhomActionIsBeingAttempted['Role']['role_name'];
			if ($idOfLoggedInUser == $idOfUserOnWhomActionIsBeingAttempted) {
				return true;
			}
			else {
			
				// Check if ADMIN user is attempting to record a PN on behalf of another user
				if (in_array($this->request->params['action'], array('apply','applyFlexiHoliday')) && $this->request->params['controller'] == 'ltsLeaveRequests') {
					//$this->Session->setFlash('You cannot raise leave requests on another\'s behalf');
					return false;	
				}
				
				// Check if logged in user is an ADMIN user
				$loggedInUser = $this->User->findById($idOfLoggedInUser);
				$roleOfLoggedInUser = $loggedInUser['PndbRole']['role_name'];
				if ($roleOfLoggedInUser == 'ADMIN' && $roleOfUserOnWhomActionIsBeingAttempted != 'ADMIN') {
					return true;
				}
				else {
					//$this->Session->setFlash('You may not be authorized to perform the requested action');
					return false;	
				}	
			}
		}
		else {
			return true;
		}	
	}	

}
