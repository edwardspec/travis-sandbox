<?php

# FIXME: whitelist target scripts, sanitize PATH_INFO, etc. (as CliEngine does)

if ( PHP_SAPI != 'cli-server' ) {
	echo "Not a valid entry point.";
	return true;
}

$rgDefaultScript = '/index.php';

###################


$uri = $_SERVER['REQUEST_URI'];
if ( $uri === '/' ) {
	$uri = $rgDefaultScript;
}

$uri = preg_replace( '[^/wiki/]', $rgDefaultScript . '?title=', $uri );
$targetScript = preg_replace( '/\?.*$/', '', $uri );

$file = realpath( $_SERVER['DOCUMENT_ROOT'] .'/'. $targetScript );
if ( substr( $file, -4, 4 ) !== '.php' ) {
	return false; /* Static file */
}

$_SERVER['SCRIPT_NAME'] = $uri;

require_once( $file );
