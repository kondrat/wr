<?php 
/* SVN FILE: $Id$ */
/* App schema generated on: 2010-04-26 22:04:29 : 1272305249*/
class AppSchema extends CakeSchema {
	var $name = 'App';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $cards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'theme_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'text_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'word' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'tr' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'def' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'cont' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'syn' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 64),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $textblocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'text_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $texts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $themes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'theme' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'card_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'current_theme' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'username' => array('type' => 'string', 'null' => true, 'length' => 64, 'key' => 'unique'),
		'password' => array('type' => 'string', 'null' => true, 'length' => 64),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'key' => 'unique'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'guest', 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'length' => 100),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'card_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'theme_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'text_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => 'username', 'unique' => 1), 'key' => array('column' => 'key', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
?>