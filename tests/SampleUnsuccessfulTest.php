<?php

class SampleUnsuccessfulTest extends MediaWikiTestCase
{
	public function testSomethingWrong() {
		global $wgFileExtensions;
		$this->assertContains( 'exe', $wgFileExtensions ); // Should fail
	}
}
