<?php

$wgEnableUploads = true; # For upload-related tests
wfLoadSkin( 'Vector' ); # Skin prints the notice which is tested by ModerationNotifyModeratorTest

wfLoadExtension( "Moderation" ); # Tested extension

$wgMainCacheType = CACHE_MEMCACHED;
$wgMemCachedServers = [ "127.0.0.1:11211" ];

# These extensions are needed for some tests of Extension:Moderation
wfLoadExtensions( [
	'AbuseFilter',
	'CheckUser'
] );

# The following extensions are tested by Selenium testsuite,
# they are not needed for PHPUnit testsuite to run.
# wfLoadExtension( 'MobileFrontend' );
# wfLoadExtension( 'VisualEditor' );
