<?php

class User extends AppModel {
	var $name = 'User';
	var $actsAs = array('Containable');
//--------------------------------------------------------------------
	var $validate = array(
							
							'username' => array(
							    			'login' => array(
																	        'rule' => '/^[a-z0-9]+$/i',  
																	        //'message' => 'Only latin letters and integers'
																	   		 ),
							    			'stopWords' => array(
																	        'rule' => array('stopWords','$this->data'),  
																	        //'message' => 'This username has already been taken'
																	   		 ),
												
												'notEmpty' => array(
																						'rule' => 'notEmpty',
																						//'message' => 'This field cannot be left blank',
																						),
																								
												'alphaNumeric' => array( 
																							'rule' => 'alphaNumeric',
																							'required' => true,
																							//'message' => 'Usernames must only contain letters and numbers.'
																							),
												
												'betweenRus' => array(
																							'rule' => array( 'betweenRus', 4, 15, 'username'),
																							//'message' => 'Username must be between 2 and 15 characters. long.',
																							'last' => true
																							),
												'checkUnique' => array( 
																							'rule' =>  array('checkUnique', 'username'),
																							//'message' => 'This username has already been taken',
																							
																							),
															),
																					
							'password1' => array( 'betweenRus' => array(
																													'rule' => array( 'betweenRus', 4, 10,'password1'),
																													//'message' => 'Username must be between 4 and 10 characters long'
																													),
																		'obvious' => array(
																												'rule' => array('obvious','$this->data'),
																												//'message' => 'Too obvious'
																											),
																	),
							'password2' => array( 'passidentity' => array(
																													'rule' => array( 'passidentity', '$this->data' ),
																													//'message' => 'Please verify your password again'
																													)
																	),
							
																																							
							'email' => array(
							
							 																	
												'notEmpty' => array(
																						'rule' => 'notEmpty',
																						//'message' => 'This field cannot be left blank!!!',
																						'required' => true,
																						'last' => true
																						),
																						
												'email' => array( 
																								'rule' => array( 'email', false), //check the validity of the host. to set true.
																								//'message' => 'Your email address does not appear to be valid!!!',
																								),
																																															
												'checkUnique' => array(           
																								'rule' =>  array('checkUnique', 'email'),
																								//'message' => 'This Email has already been taken!!!',
																								
																								),
																								
															),
							'captcha' => array( 'notEmpty' => array(
																										'rule' => 'notEmpty',
																										//'message' => 'This field cannot be left blank',
																										'last'=>true,
																	),
																	'alphaNumeric' => array(
																										'rule' => 'alphaNumeric',
																										//'message' => 'Only contain letters and numbers'
																	),
																	'equalCaptcha' => array(
        																						'rule' => array('equalCaptcha','$this->data'),  
        																						//'message' => 'Please, correct the code'
    															),

											),

																										 
						  );

//--------------------------------------------------------------------
	var $belongsTo = array(
        'Group' => array(
            'className'    => 'Group',
            'foreignKey'    => 'group_id'
        )
  );
  
	var $hasMany = array(
	/*
		'Theme' => array(
			'className' => 'Theme',
			'foreignKey' => 'user_id',
			'dependent' => false
		)
		*/
	);  

/*
	var $hasAndBelongsToMany = array(
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'projects_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'project_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
*/
//--------------------------------------------------------------------
	function betweenRus($data, $min, $max, $key) {
		//debug($data);
		$length = mb_strlen($data[$key], 'utf8');

		if ($length >= $min && $length <= $max) {
			return true;
		} else {
			return false;
		}
	}

//--------------------------------------------------------------------														
	function checkUnique($data, $fieldName) {
    	$valid = false;
    	if(isset($fieldName) && $this->hasField($fieldName)) {
      		$valid = $this->isUnique(array($fieldName => $data));
     	}
        return $valid;
   }
//--------------------------------------------------------------------
	function obvious($data){
		if ( $this->data['User']['password1'] === $this->data['User']['username'] ) {
			return false;
		}
		return true;
	}
//--------------------------------------------------------------------
	function stopWords($data){
		if ( $a = Configure::read('stopWords')  ) {

			$toCheck = strtolower($this->data['User']['username']);
			$res = str_replace($a, "", $toCheck );
			if( $res !== $toCheck ) {			
				return false;
			}
		}
		return true;
	}
//--------------------------------------------------------------------														
	function passidentity($data) {
 		if ( $this->data['User']['password1'] != $this->data['User']['password2'] ) {		
        	return false;
    	}
    	return true;
   	}
   	
//--------------------------------------------------------------------														
	function equalCaptcha($data) {
 		if ( $this->data['User']['captcha'] != $this->data['User']['captcha2'] ) {		
        	return false;
    	}
    	return true;
   	}
//--------------------------------------------------------------------	
	function beforeSave() {
        if ( !empty($this->data['User']['password1']) ) {
        	$this->data['User']['password'] = sha1( Configure::read('Security.salt').$this->data['User']['password1'] ); 
        }  
        return true;    
    }
//--------------------------------------------------------------------	
	function getUserData( $userName=null ) {
		$userDataOutput = false;
 		$this->recursive = 0;
		$userData = $this->findByUsername( $userName, array('fildes' =>  'User.username' ) );
		if ( $userData ) {
			$userDataOutput['ID'] = $userData['User']['id'];
		} else {
			$userDataOutput['ID'] = null;
		}
        return $userDataOutput;    
    }
//--------------------------------------------------------------------
    /**
     * Creates an activation hash for the current user.
     *      @param Void
     *      @return String activation hash.
    */
    function getActivationHash() {
    	if ( !isset($this->id) ) {
   			return false;
 		}
  		return substr( Security::hash( Configure::read('Security.salt') . $this->field('created') . date('Ymd') ), 0, 8 );
    }
//--------------------------------------------------------------------


}

?>
