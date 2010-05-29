<?php
class AppController extends Controller {
	var $components = array( 'Security','Cookie','Session','Auth','AutoLogin', 'RequestHandler', 'Email',
				'DebugKit.Toolbar'
			);
	var $helpers = array('Session','Js','Html', 'Form', 'Cache');
	var $publicControllers = array('pages', 'test');
//--------------------------------------------------------------------
	function beforeFilter() {
	

		/*
		
		if ( !isset($this->params['lang']) && !$this->Session->check('langSes') ) {
			
			$this->params['lang'] = $defaultLang;
			$this->Session->write('langSes',$defaultLang);

		} elseif ( !isset($this->params['lang']) && $this->Session->check('langSes') ) {
			$this->params['lang'] = $this->Session->read('langSes');
		} 

		Configure::write('Config.language', $this->params['lang']);
		$this->Session->write('langSes',$this->params['lang']);
		*/







		
        if( isset($this->Auth) ) {
								
            if($this->viewPath == 'pages' && $this->params['action'] != 'admin_index') {
                $this->Auth->allow('*');
            } else {
                $this->Auth->authorize = 'controller';
	            if ( in_array( low($this->params['controller']), $this->publicControllers) ) {
                	//$this->Auth->allow('*');
                	$this->Auth->deny('pages/admin_index');
                }
            }
            $this->Auth->loginAction = array('admin' => false, 'controller' => 'users', 'action' => 'login');

        } 
				
	}
	
		function isAuthorized() {

            if ('1' == '1') {
                return true;
            } else {
                return false;
            }
        return true;
    }
	
//--------------------------------------------------------------------

	function beforeRender() {
		if( isset($this->params['prefix']) && $this->params['prefix'] == 'admin' ) {	
			$this->layout = 'admin';
		}				
	}
//--------------------------------------------------------------------




}
?>
