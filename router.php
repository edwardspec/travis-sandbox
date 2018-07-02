<?php
###############################################################################
#
# NOT FOR PRODUCTION USE. ONLY FOR AUTOMATIC TESTS.
#
# Router script for built-in php-cli server (development only).
# Serves MediaWiki.
#
# Usage: php -S 127.0.0.1:8080 -t /var/www/html router.php
# ... where /var/www/html is the document root.
#
###############################################################################

# Folder with MediaWiki (under the document root)
$rgScriptRoot = 'mediawiki';

# Same values as in LocalSettings.php
$wgScriptPath = "/w";
$wgArticlePath = "/wiki/$1";

###############################################################################

$uri = $_SERVER['REQUEST_URI'];

# Rewrite 1: / -> /w/index.php
if ( $uri === '/' ) {
	$uri = "$wgScriptPath/index.php";
}

# Rewrite 2: /wiki/Article -> /w/index.php?title=Article
$articlePathRegex = join( '(.*)', array_map( 'quotemeta', explode( '$1', $wgArticlePath ) ) );
$uri = preg_replace( '[^' . $articlePathRegex . '$]', '/w/index.php?title=$1', $uri );

# Rewrite 3: /w/ -> /MediaWikiFolderName/
$aliasCount = 0; # Will become 1 if the path was rewritten
$uri = preg_replace( '[^/w/]', "/$rgScriptRoot/", $uri, -1, $aliasCount );

# Strip QUERY_STRING and find the target file
$targetScript = preg_replace( '/\?.*$/', '', $uri );
$path = realpath( $_SERVER['DOCUMENT_ROOT'] .'/'. $targetScript );
if ( substr( $path, -4, 4 ) !== '.php' ) {
	if ( $aliasCount > 0 ) {
		header( 'Location: ' . $uri, true, 302 );
		return true;
	}

	return false; /* Static file */
}

$_SERVER['SCRIPT_NAME'] = $uri;
require_once( $path );
