<?php 
	//words not to be used for user's logins.
	// app/models/user.php, app/js/dev/reg.js
	$config['stopWords'] = array('admin','workroll','workrol','wrkroll');
	
	//items task types
	$config['itemTasks'] = array( array('n'=> 0,'t'=>__('ToDo',true) ), array('n'=> 1,'t'=> __('Ticket',true) ), array('n'=> 3,'t'=> __('Idea',true)), array('n'=> 2,'t'=>__('Impr',true) ) );
	//items statuses types
	$config['itemStatuses'] = array( array('n'=> 0,'t'=> __('opend',true) ) ,array('n'=> 1,'t'=> __('closed',true)),array('n'=> 2,'t'=> __('hold',true) ), array('n'=> 3, 't'=>'cancel') );

	
?>