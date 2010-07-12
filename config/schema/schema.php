<?php 
/* SVN FILE: $Id$ */
/* App schema generated on: 2010-07-12 21:07:07 : 1278955567*/
class AppSchema extends CakeSchema {
	var $name = 'App';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 64),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $items = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'item' => array('type' => 'string', 'null' => true, 'default' => '0'),
		'task' => array('type' => 'string', 'null' => true, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => true, 'default' => '0'),
		'target' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'pos' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $projects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => '0'),
		'current' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64, 'key' => 'unique'),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'key' => 'unique'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'guest', 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'key' => 'unique'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'item_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'project_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => 'username', 'unique' => 1), 'key' => array('column' => 'key', 'unique' => 1), 'email' => array('column' => 'email', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
?>