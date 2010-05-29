<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array();
	var $components = array( 'userReg','kcaptcha');

	var $paginate = array('limit' => 5);
	
//--------------------------------------------------------------------
//--------------------------------------------------------------------	
  function beforeFilter() {
  			//default title
  			$this->set('title_for_layout', __('Users data',true) );
  			//allowed actions
        $this->Auth->allow( 'logout','login', 'reg','kcaptcha', 'reset', 'userNameCheck','index','view'
        										//'acoset','aroset','permset','buildAcl'
        										);

        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
        
        // swiching off Security component for ajax call
        
				if( $this->RequestHandler->isAjax() && $this->action == 'userNameCheck' ) { 
		   			$this->Security->validatePost = false;
		   	}
		   	
		   	

    }

//--------------------------------------------------------------------
//--------------------------------------------------------------------	
	function reg() {


		$this->set('title_for_layout', __('SignUp',true) );
		
		if($this->Auth->user('id') && $this->Auth->user('group_id') != 2 ) {
			$this->redirect('/',null,true);
		}
		
		
		if ( !empty($this->data) ) {
						
			$this->data['User']['captcha2'] = $this->Session->read('captcha');

			if ( $this->User->save( $this->data) ) {											
				$a = $this->User->read();
				$this->Auth->login($a);
				$this->Session->setFlash(__('New user\'s accout has been created',true), 'default', array('class' => 'flok'));
				$this->redirect(array('controller' => 'cards','action'=>'index'),null,true);
      } else {
				$this->data['User']['captcha'] = null;
				$this->Session->setFlash(__('New user\'s accout hasn\'t been created',true) , 'default', array('class' => 'fler') );
			}
		}
		
		

	}	
//--------------------------------------------------------------------	
//ajax staff
	//----------------------------------------------------------------
		function userNameCheck() {
			Configure::write('debug', 0);
			$this->autoLayout = false;
			$this->autoRender = false;
			
			if ( $this->RequestHandler->isAjax() ){

				if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
					$this->Security->blackHole($this, 'Invalid referrer detected for this request!');
				}


				
				$errors = array();
				$this->header('Content-Type: application/json');
			
				//don't foreget about santization and trimm
				if (!empty($this->data) && $this->data['User']['username'] != null) {

						$this->User->set( $this->data );
						$errors = $this->User->invalidFields();
						if($errors == array()) {
							$type = 1;
							$errors['username'] = __('Login is free',true);
						} else {
							$type = 0;
						}
						
						echo json_encode(array('ok'=> __($errors['username'],true), 'er'=> $type));
					 	exit();
					 									
						

				} else {
						echo json_encode(array('hi'=> __('This field cannot be left blank',true), 'er'=> 0));
						exit();	
				}		
			} else {				
				$this->Security->blackHoleCallback = 'gotov';	
				$this->Security->blackHole($this, 'You are not authorized to process this request!');			
			}
			
		}
				//blackhole redirection
				//-----------------------------
				function gotov() {
					$this->redirect(null, 404, true);
				}	
		//kcaptcha stuff
		//----------------------------------------------------------------
    function kcaptcha() {
        $this->kcaptcha->render(); 
    } 
    function kcaptchaReset() {
    	Configure::write('debug', 0);
    	$this->autoRender = false;
     	$this->kcaptcha->render(); 
     	exit();
    } 
//--------------------------------------------------------------------
	function login() {
		
		$this->set('title_for_layout', __('Login',true) );

//add logic for group_id == 2 here
		if( !empty($this->data) ) {

			if( $this->Auth->login() ) {
						$this->redirect( $this->Auth->redirect() );			
			} else {
				$this->data['User']['password'] = null;
				$this->Session->setFlash(__('Check your login and password',true),'default', array('class' => 'fler'));
			}
			
		} else {

			if( !is_null( $this->Session->read('Auth.User.username') ) && $this->Session->read('Auth.User.group_id') != 2 ){
				$this->redirect( $this->Auth->redirect() );			
			} 
		}
		
	}

//--------------------------------------------------------------------	
    function logout() { 
    		$guest =  false;   	    	
    		$tempUserName = __('Good bay, ',true).$this->Session->read('Auth.User.username'); 
    		if( $this->Session->read('Auth.User.group_id') == 2 ) {
    			$guest =  true;
    		}
    			
        $this->Auth->logout();
        if (!$guest) {
        	$this->Session->setFlash( $tempUserName, 'default', array('class' => 'flok') );
        }
        $this->redirect( '/',null,true);        
    }
//--------------------------------------------------------------------	



	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
