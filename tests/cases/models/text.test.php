<?php
/* Text Test cases generated on: 2010-04-08 21:04:08 : 1270748228*/
App::import('Model', 'Text');

class TextTestCase extends CakeTestCase {
	var $fixtures = array('app.text', 'app.user');

	function startTest() {
		$this->Text =& ClassRegistry::init('Text');
	}

	function endTest() {
		unset($this->Text);
		ClassRegistry::flush();
	}

}
?>