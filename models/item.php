<?php
class Item extends AppModel {
	var $name = 'Item';
	var $actsAs = array(
            'Containable',
            'Tags.Taggable'//=>array('field' => false)
        );
	//var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'counterCache' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'counterCache' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
?>
