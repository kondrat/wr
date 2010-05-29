<?php
/* Theme Test cases generated on: 2010-04-13 13:04:15 : 1271150475*/
App::import('Model', 'Theme');

class ThemeTestCase extends CakeTestCase {
	var $fixtures = array('app.theme', 'app.user', 'app.card');

	function startTest() {
		$this->Theme =& ClassRegistry::init('Theme');
	}

	function endTest() {
		unset($this->Theme);
		ClassRegistry::flush();
	}

}
?>