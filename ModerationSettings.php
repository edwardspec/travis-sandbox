<?php

# URL of the testwiki (as configured in .travis.yml).
$wgServer = "http://moderation.example.com";
$wgScriptPath = "/mediawiki";
$wgArticlePath = "/wiki/$1";

# For upload-related tests
$wgEnableUploads = true;

# Skin prints the notice which is tested by ModerationNotifyModeratorTest
wfLoadSkin( 'Vector' );

# Object cache is needed for ModerationNotifyModeratorTest
$wgMainCacheType = CACHE_MEMCACHED;
$wgMemCachedServers = [ "127.0.0.1:11211" ];

# Don't trigger $wgRateLimits in simultaneous Selenium tests
$wgGroupPermissions['*']['noratelimit'] = true;

# These extensions are needed for some tests of Extension:Moderation
wfLoadExtensions( [
	# For PHPUnit testsuite
	'AbuseFilter',
	'CheckUser',

	# For Selenium testsuite
	'MobileFrontend',
	'VisualEditor'
] );

# Default skin for Extension:MobileFrontend
if ( version_compare( $wgVersion, '1.30.0', '>=' ) ) {
	# MediaWiki 1.27-1.29 have this skin included into MobileFrontend
	wfLoadSkin( 'MinervaNeue' );
}

# Parsoid configuration (used by Extension:VisualEditor)
$wgVirtualRestConfig['modules']['parsoid'] = [
	'url' => 'http://moderation.example.com:8142',
	'domain' => 'moderation.example.com'
];
$wgDefaultUserOptions['visualeditor-enable'] = 1; # Enable VisualEditor for all users

# Tested extension
wfLoadExtension( "Moderation" );
