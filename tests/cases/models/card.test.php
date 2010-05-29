<?php
/* Card Test cases generated on: 2010-03-12 20:03:07 : 1268414947*/
App::import('Model', 'Card');

class CardTestCase extends CakeTestCase {
	var $fixtures = array('app.card', 'app.user');

	function startTest() {
		$this->Card =& ClassRegistry::init('Card');
	}

	function endTest() {
		unset($this->Card);
		ClassRegistry::flush();
	}

}
?>