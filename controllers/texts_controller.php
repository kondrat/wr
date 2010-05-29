<?php
class TextsController extends AppController {

	var $name = 'Texts';
	var $publicActions = array('textUpload');

//--------------------------------------------------------------------
//--------------------------------------------------------------------	
  function beforeFilter() {

  			//default title
  			$this->set('title_for_layout', __('Text upload',true) );
  			//allowed actions
        $this->Auth->allow('add','textUpload','ttest');

        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
        
        // swiching off Security component for ajax call
        
        //to be rebuild
				if( $this->RequestHandler->isAjax() && in_array( $this->action, $this->publicActions) ) { 
		   			$this->Security->validatePost = false;
		   	}
		   	
		   	

    }

//--------------------------------------------------------------------
//--------------------------------------------------------------------

	//ajax staff
		//----------------------------------------------------------------

	function ttest(){
		$text1 = "It goes <div style='color:red;'>was</div> a time when Zack Morris phone jokes weren't invented yet, but leaving a prototype phone in a bar would have still kicked your professional ass. You see, when Cooper was trucking around a cellphone in 1973, it weighed nearly two kilos and cost approximately $1 million for Motorola to produce. Battery life was a brisk 20 minutes. Order a pizza or do more QA testing?�choices! Fast forward to today, and Cooper is put off by the size of a smartphone's instruction manual (often larger and heavier than the phone itself, he says), which he argues can require an engineer's expertise to figure out. No bother though, as Cooper predicts that in the not-so-distant future tiny cellphone implants ill deliver calls from mom via the bony spots behind our ears.";
		$keywords = preg_split("/(\.|\!|\?)[\s]+/", $text1);
		debug($keywords);
	}	


	function textUpload() {
		
			$contents = false;
			$ttText = null;
			$finPhrase = '';
			$strLen = null;
			
			//ajax preparation
			Configure::write('debug', 0);
			$this->autoLayout = false;
			$this->autoRender = false;
			
			if ( $this->RequestHandler->isAjax() ){

				if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
					$this->Security->blackHoleCallback = 'gotov';
				}
				//main staff
				
					$ttText = trim($this->data['Text']['text']);
					App::import('Sanitize');
					$ttText = Sanitize::html($ttText);
					
					$text1 = "It goes <div style='color:red;'>was</div> a time when Zack Morris phone jokes weren't invented yet, but leaving a prototype phone in a bar would have still kicked your professional ass. You see, when Cooper was trucking around a cellphone in 1973, it weighed nearly two kilos and cost approximately $1 million for Motorola to produce. Battery life was a brisk 20 minutes. Order a pizza or do more QA testing?�choices! Fast forward to today, and Cooper is put off by the size of a smartphone's instruction manual (often larger and heavier than the phone itself, he says), which he argues can require an engineer's expertise to figure out. No bother though, as Cooper predicts that in the not-so-distant future tiny cellphone implants ill deliver calls from mom via the bony spots behind our ears.";
					$keywords = preg_split("/(\.|\!|\?)[\s]+/", $ttText);
					

					$l = 0;	
					$k = 1;
					foreach(	$keywords as $keyW ) {
						if($strLen >=2400*$k){
							$l++;
							$k++;
						}
						if ( substr($keyW, -1) === '.') {
							$finPhrase[$l][] = substr($keyW, 0,-1);
						} else {
							$finPhrase[$l][] = $keyW;
						}
						$strLen += strlen($keyW);
						
					}	
					
					//Configure::write('debug', 2);	
					//debug($finPhrase);					
					$contents = json_encode( array("stat" => 1,'strlen'=> $strLen,'resText' => $finPhrase));
				

	
					$this->header('Content-Type: application/json');				
					return ($contents);
					
								
			} else {				
				$this->Security->blackHoleCallback = 'gotov';		
			}
			
			
					
	}

		//----------------------------------------------------------------
				//blackhole redirection
				//-----------------------------
				function gotov() {	
					$this->redirect(null, 404, true);
				}	
//--------------------------------------------------------------------
	function add() {
		$lastCards = array();
		$curTheme = array();
		$authUserId = $this->Auth->user('id');
		
		
	
		if ( $authUserId != null ) {

			$curTheme = $this->Text->Theme->find('all', array(
					'conditions' => array('Theme.user_id' => $this->Auth->user('id') ),
					'fields' => array('Theme.theme'),
					'order' => array('Theme.current_theme DESC'),
					'limit' => 1,
					'contain' => array('Card' => array(
																							'fields' => array('Card.word'),
																							'limit'=> 10,
																							'order'=>'Card.id DESC'
																						)
														)
				)			
			);
		
		}

		$allThemes = $this->Text->Theme->find('list', array(
					'conditions' => array('Theme.user_id' => $this->Auth->user('id') ),
					'fields' => array('Theme.id','Theme.theme'),
					'order' => array('Theme.id DESC'),
					'contain' => false
			)
		);

		$this->set('curTheme', $curTheme);
		
		$this->set('allThemes',$allThemes);
	}
//--------------------------------------------------------------------


	function index() {
		$this->Text->recursive = 0;
		$this->set('texts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid text', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('text', $this->Text->read(null, $id));
	}



	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid text', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Text->save($this->data)) {
				$this->Session->setFlash(__('The text has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The text could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Text->read(null, $id);
		}
		$users = $this->Text->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for text', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Text->delete($id)) {
			$this->Session->setFlash(__('Text deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Text was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Text->recursive = 0;
		$this->set('texts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid text', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('text', $this->Text->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Text->create();
			if ($this->Text->save($this->data)) {
				$this->Session->setFlash(__('The text has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The text could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Text->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid text', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Text->save($this->data)) {
				$this->Session->setFlash(__('The text has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The text could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Text->read(null, $id);
		}
		$users = $this->Text->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for text', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Text->delete($id)) {
			$this->Session->setFlash(__('Text deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Text was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>