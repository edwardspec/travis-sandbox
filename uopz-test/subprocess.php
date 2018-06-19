<?php

/*
	This evaluates the performance impact of uopz_set_return()
	being enabled when executing MediaWiki code.
*/

require_once 'Maintenance.php';

class UopzTest extends Maintenance {
	public function execute() {
		if ( function_exists( 'uopz_set_return' ) ) {
			uopz_set_return( 'header', function( $string, $replace = true, $http_response_code = null ) {
				echo "Header [$string] found; replace=" . (bool)$replace . ", http_code=[", (string)$http_response_code . "]\n";
			}, true );
		}

		header( 'User-Agent: something/1.0.0' );
		header( 'User-Agent: something/1.0.1', true );
		header( 'Content-Type: image/png', false, 404 );
	}
}

$maintClass = UopzTest::class;
require_once RUN_MAINTENANCE_IF_MAIN;
