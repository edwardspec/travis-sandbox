<?php

/*
	This evaluates the performance impact of uopz_set_return()
	being enabled when executing MediaWiki code.
*/

class UopzTest extends Maintenance {

	public function execute() {
		if ( function_exists( 'uopz_set_return' ) ) {
			uopz_set_return( 'header', function( $string, $replace = true, $http_response_code = null ) {
				echo "Header [$string] found; replace=" . (bool)$replace . ", http_code=[", (string)$http_response_code . "]\n";
			}, true );
		}

		/* Call some MediaWiki functions to determine if uopz has
			any performance impact on code that doesn't use header() */
		$count = 500;
		$user = User::createNew( 'testuser1' );
		for ( $i = 1; $i <= $count; $i ++ ) {
			$title = Title::makeTitle( NS_MAIN, "Page " . $i );
			$page = WikiPage::factory( $title );
			$content = ContentHandler::makeContent( '', $title );

			$page->doEditContent( $content, '', 0, false, $user );

			if ( $i % 25 == 0 ) {
				echo "Made $i edits.\n";
			}
		}

		header( 'User-Agent: something/1.0.0' );
		header( 'User-Agent: something/1.0.1', true );
		header( 'Content-Type: image/png', false, 404 );
	}
}

$maintClass = UopzTest::class;
require_once RUN_MAINTENANCE_IF_MAIN;
