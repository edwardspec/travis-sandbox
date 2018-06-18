<?php

$wgEnableUploads = true;

wfLoadExtension( "Moderation" );

# Disable display_errors from DevelopmentSettings.php
# (interferes with ModerationTestsuiteCliEngine)
ini_set( 'display_errors', 0 );

$wgMainCacheType = CACHE_MEMCACHED;
$wgMemCachedServers = [ "127.0.0.1:11211" ];
