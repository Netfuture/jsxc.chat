<?php

namespace OCA\OJSXC;

use OCA\OJSXC\Db\Message;
use OCA\OJSXC\Db\Pollable;
use OCA\OJSXC\Db\Presence;
use OCA\OJSXC\Utility\TestCase;

class NewContentContainerTest extends TestCase {

	/**
	 * @var NewContentContainer $newContentContainer
	 */
	private $newContentContainer;

	public function setUp() {
		$this->newContentContainer = new NewContentContainer();
		$this->setValueOfPrivateProperty($this->newContentContainer, 'stanzas', []);
	}

	public function tearDown() {
		$this->setValueOfPrivateProperty($this->newContentContainer, 'stanzas', []);
	}

	public function testProvider() {
		$stanza1 = new Presence();
		$stanza1->setFrom('test@own.dev');
		$stanza1->setPresence('away');
		$stanza1->setTo('adsffdsst@own.dev');

		$stanza2 = new Message();
		$stanza2->setFrom('test@own.dev');
		$stanza2->setTo('addsf@own.dev');
		$stanza2->setType('chat');
		$stanza2->setValue('abc');
		return [
			[
				[$stanza1, $stanza2],
				2
			]
		];
	}

	/**
	 * @dataProvider testProvider
	 */
	public function test($stanzas, $count) {
		foreach ($stanzas as $stanza) {
			$this->newContentContainer->addStanza($stanza);
		}
		$this->assertEquals($count, $this->newContentContainer->getCount());

		$result = $this->newContentContainer->getStanzas();
		$this->assertEquals(sort($stanzas), sort($result));

	}


}