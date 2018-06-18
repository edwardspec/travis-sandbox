<?php

class SampleSuccessfulTest extends MediaWikiTestCase
{
	public function testSomething() {
		global $wgFavicon;
		$this->assertEquals( '/favicon.ico', $wgFavicon ); // Should succeed
	}
}
