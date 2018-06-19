<?php

if ( function_exists( 'uopz_set_return' ) ) {
	uopz_set_return( 'header', function( $string, $replace = true, $http_response_code = null ) {
		echo "Header [$string] found; replace=" . (bool)$replace . ", http_code=[", (string)$http_response_code . "]\n";
	}, true );
}

header( 'User-Agent: something/1.0.0' );
header( 'User-Agent: something/1.0.1', true );
header( 'Content-Type: image/png', false, 404 );
