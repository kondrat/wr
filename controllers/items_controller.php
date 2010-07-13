<?php
class ItemsController extends AppController {

	var $name = 'Items';
	var $publicActions = array('saveItem' );


//--------------------------------------------------------------------
//--------------------------------------------------------------------	
  function beforeFilter() {

  			//default title
  			$this->set('title_for_layout', __('Items',true) );
  			//default menuType
  			$this->set('menuType', 'todo');
  			//allowed actions
        $this->Auth->allow('index','view','getTransl');

        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
        
        // swiching off Security component for ajax call

				if( $this->RequestHandler->isAjax() && in_array( $this->action, $this->publicActions) ) { 
		   			$this->Security->validatePost = false;
		   	}
				
  }

//--------------------------------------------------------------------
//--------------------------------------------------------------------


//--------------------------------------------------------------------
	//ajax staff

		//----------------------------------------------------------------
			
	function saveItem() {
		
		$auth = false;
		$currentThemeId = array();
		$newThemeId = null;
		$authUserId = null;
		$contents['proj'] = 0;
		
		//ajax preparation
		Configure::write('debug', 0);
		$this->autoLayout = false;
		$this->autoRender = false;
			
			if ( $this->RequestHandler->isAjax() ){
				
						//our host only
						if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
							$this->Security->blackHoleCallback = 'gotov';
						}
				
				//main staff
					$authUserId = $this->Auth->user('id');
					
					if ( $authUserId !== null ) {
						
						$auth = true;

									if( !isset($this->data['Item']['item']) || $this->data['Item']['item'] == null ) {
										$contents['stat'] = 0;
						        $contents = json_encode($contents);
										$this->header('Content-Type: application/json');				
										return ($contents);
									}
									
									$nw = $this->data['Item']['epoch'];
									
									$contents['date'] = date('Y-m-d', $nw);
									
									/*
									$this->data['Item']['hour'];
									$this->data['Item']['min'];		
									*/							
									$this->data['Item']['user_id'] = $authUserId;
									$this->data['Item']['target'] = $contents['date'];
									
									
									
									//$this->data['Item']['target'] = $this->data['Item']['year'].'-'.$this->data['Item']['month'].'-'.$this->data['Item']['day'];
									//$this->data['Item']['target'] = $this->data['Item']['year'].'-'.$this->data['Item']['month'].'-'.$this->data['Item']['day'];
										
					
					}
					

					//not reg yet. not work for a moment
					if( !$auth  ) {
						
							//no data about user in db. So we reg it in.
							$key = 'guest_'.md5(uniqid(rand(), true));
							//$this->Cookie->write('guestKey',$key, false, '360 days');	
							
							//we reg the guest as a temp user
							$this->data['User']['username'] = $key;
							$this->data['User']['group_id'] = 2;
							$this->data['User']['password'] = 1234;
							
							/*
							if ( $this->Item->User->save($this->data, array('validate' => false) ) ) {
								
									$a = $this->Item->User->read(array('id','username','password'));
									//$a['User']['auto_login'] = 1;
																	
									$this->Auth->login($a);	
	
									$this->data["Item"]["user_id"] = $a['User']['id'];
															
									$this->data['Theme']['theme'] = $this->data['Theme']['theme'];
									$this->data['Theme']['user_id'] = $a['User']['id'];
									$this->data['Theme']['current_theme'] = time();
									
									//creating of the first theme
									if( $this->Item->Theme->save($this->data) ) {									
										$newThemeId = $this->Item->Theme->id;
										$this->data["Item"]["theme_id"] = $newThemeId;
										$contents['theme'] = 1;	
										$contents['themeName'] = $this->data['Theme']['theme'];
										$contents['themeId'] = $newThemeId;									
									}else{
										//report server problem
									}	
																					
							} else {
								//report server problem
							}						
							*/
					} 

				
				

									
				

					if( $this->Item->save($this->data) ) {
						$contents['stat'] = 1;
						$contents['word'] = $this->data["Item"]["item"];
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
		$this->set('title_for_layout', __('Main page',true) );		
		$this->set('menuType', 'index');
		
    if ($authUserId = $this->Auth->user('id') ) {
    	$this->redirect(array('action' => 'todo'));
    } 
		
	}
//--------------------------------------------------------------------
	function todo() {
		$this->set('menuType', 'todo');
		$todos = array();
		$authUserId = $this->Auth->user('id');
		$pagItemCond = array();
		$curPrj = array();

				
		$this->paginate['limit'] = 6;
		$this->paginate['contain'] = false;
		
		

		if ( isset($this->params['named']['prj']) && (int)$this->params['named']['prj'] != 0 ) {
			
			$pagItemCond = array('Item.user_id'=> $authUserId , 'Item.project_id'=> $this->params['named']['prj'] );
			//we selected new prj, so updade the cur time
			if(isset($this->params['url']['cur'])&&$this->params['url']['cur']==="1"){
				$prId = $this->Item->Project->find('first',array('conditions'=> array('Project.id' => $this->params['named']['prj']),'contain'=>false) );
				if( $prId != array() ) {
					$this->data['Project']['current'] = time();
					$this->data['Project']['id'] = (int)$this->params['named']['prj'];
					$this->Item->Project->save($this->data);
				}
			}
			
			
		} else if( isset($this->params['named']['prj']) && $this->params['named']['prj'] === 'all'){
			$pagItemCond = array('Item.user_id'=> $authUserId);
		} else {

			
			$curPrj = $this->Item->Project->find('all', array(
																													'conditions'=> array('Project.user_id'=> $authUserId, 'Project.active' => 1),
																													'fields'=> array('id','name'),
																													'order'=> array('current'=>'DESC'),
																													'contain'=>false)
																					);
			//check if this user is new, or has current project he whorks on.																		
			if($curPrj == array() ){
				$this->data['Project']['user_id'] = $authUserId;
				$this->data['Project']['name'] = __('Project 1',true);
				$this->data['Project']['current'] = time();
				$this->Item->Project->save($this->data);
				$curPrj[0] = $this->Item->Project->read();
			}					
			
						$pagItemCond = array('Item.user_id'=> $authUserId,'Item.project_id'=> $curPrj[0]['Project']['id'] );
			
			
		}
		$this->paginate['conditions'] = $pagItemCond;

		
		$this->set('todos',$this->paginate('Item') );

		if( $this->RequestHandler->isAjax() && isset($this->params['named']['page'])  ) {
			Configure::write('debug', 0);
			$this->autoLayout = false;
			
			
			
			
			$this->render('ajax_item');
			return;
		}
		

		
		$this->set('curPrj',$curPrj);		


	}
//--------------------------------------------------------------------
	function diary() {

	}
//--------------------------------------------------------------------
	function note() {

	}
//--------------------------------------------------------------------










	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('Item', $this->Item->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Item->create();
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Item->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Item->read(null, $id);
		}
		$users = $this->Item->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Item->delete($id)) {
			$this->Session->setFlash(__('Item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Item was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Item->recursive = 0;
		$this->set('Items', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('Item', $this->Item->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Item->create();
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Item->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The Item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Item->read(null, $id);
		}
		$users = $this->Item->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Item->delete($id)) {
			$this->Session->setFlash(__('Item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Item was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
