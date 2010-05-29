<?php
class ThemesController extends AppController {

	var $name = 'Themes';
	var $publicActions = array('updateTheme','selTheme' );
//--------------------------------------------------------------------
//--------------------------------------------------------------------	
  function beforeFilter() {

  			//default title
  			$this->set('title_for_layout', __('Cards',true) );
  			//allowed actions
        $this->Auth->allow(
                          'updateTheme',
                          'selTheme',
                          'test'
                          );

        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
        
        // swiching off Security component for ajax call

				if( $this->RequestHandler->isAjax() && in_array( $this->action, $this->publicActions) ) { 
		   			$this->Security->validatePost = false;
		   	}

  }

//--------------------------------------------------------------------
//--------------------------------------------------------------------

	function test(){
			$ttM = $this->Theme->find('all',array(
			                                        'conditions'=> array( 
			                                                            //'Theme.current_theme MAX',
			                                                            // 'theme' =>'MAX(theme)' 
			                                                            //'Theme.id' => $this->Auth->user('id') 
			                                                            ),
			                                         'fields'=> array('id',
			                                                          'theme',
			                                                          'current_theme'
			                                                          ),
			                                         'order'=>array('Theme.current_theme DESC'),
			                                         'contain'=>false
			                                        )
			                          );
				  Configure::write('debug', 2);
			  	$this->set('ttm',$ttM);
				  //exit();	
	}
	
//--------------------------------------------------------------------
	//ajax staff
		//----------------------------------------------------------------
	function updateTheme(){
		//ajax preparation
		Configure::write('debug', 0);
		$this->autoLayout = false;
		$this->autoRender = false;
			
			if ( $this->RequestHandler->isAjax() ){
							
						//our host only
						if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
							$this->Security->blackHoleCallback = 'gotov';
						}		
				
				$auth = $this->Auth->user('id');				
				
				if($auth){
					
						$this->data['Theme']['current_theme'] = time();
						$this->data['Theme']['user_id'] = $auth;

						if($this->Theme->save($this->data) ) {
							$contents['stat'] = 1;
							$contents['theme'] = $this->data["Theme"]["theme"];
							if( !isset($this->data['Theme']['id']) ){
								$newThemeId = $this->Theme->id;
								$contents['themeId'] = $newThemeId;
							} else {
								$contents['themeId'] = $this->data['Theme']['id'];
							}
						}	else {
							$contents['stat'] = 0;
						}					
					
				} else {
					$contents['stat'] = 0;
				}
			

					
	      $contents = json_encode($contents);
				$this->header('Content-Type: application/json');				
				return ($contents);						
							
			} else {				
				$this->Security->blackHoleCallback = 'gotov';		
			}		
	}


	function selTheme(){
		//ajax preparation
		Configure::write('debug', 0);
		$this->autoLayout = false;
		$this->autoRender = false;
			
			if ( $this->RequestHandler->isAjax() ){
							
						//our host only
						if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
							$this->Security->blackHoleCallback = 'gotov';
						}		
				
				$auth = $this->Auth->user('id');				
				
				if($auth && $this->data['Theme']['id'] != null ){
					
						$this->data['Theme']['current_theme'] = time();
						

						if($this->Theme->save($this->data) ) {
							$contents['stat'] = 1;
							
							$allThemeCards = $this->Theme->Card->find('all', array(
									'conditions' => array('Card.theme_id' => $this->data['Theme']['id'], 'Card.user_id' => $auth),
									'fields' => array('Card.id','Card.word'),
									'order' => array('Card.id DESC'),
									'contain' => false
								)
							);
							
							$contents['cards'] = $allThemeCards;
							
							
						}	else {	
							$contents['stat'] = 0;
						}					

						




					
				} else {
					$contents['stat'] = 0;
				}
			

					
	      $contents = json_encode($contents);
				$this->header('Content-Type: application/json');				
				return ($contents);						
							
			} else {				
				$this->Security->blackHoleCallback = 'gotov';		
			}		
	}
	
	
	
	
				//blackhole redirection
				//-----------------------------
				function gotov() {	
					$this->redirect(null, 404, true);
				}	






//--------------------------------------------------------------------
	function index() {
		$this->Theme->recursive = 0;
		$this->set('themes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid theme', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('theme', $this->Theme->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Theme->create();
			if ($this->Theme->save($this->data)) {
				$this->Session->setFlash(__('The theme has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The theme could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Theme->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid theme', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Theme->save($this->data)) {
				$this->Session->setFlash(__('The theme has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The theme could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Theme->read(null, $id);
		}
		$users = $this->Theme->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for theme', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Theme->delete($id)) {
			$this->Session->setFlash(__('Theme deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Theme was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Theme->recursive = 0;
		$this->set('themes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid theme', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('theme', $this->Theme->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Theme->create();
			if ($this->Theme->save($this->data)) {
				$this->Session->setFlash(__('The theme has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The theme could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Theme->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid theme', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Theme->save($this->data)) {
				$this->Session->setFlash(__('The theme has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The theme could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Theme->read(null, $id);
		}
		$users = $this->Theme->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for theme', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Theme->delete($id)) {
			$this->Session->setFlash(__('Theme deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Theme was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
