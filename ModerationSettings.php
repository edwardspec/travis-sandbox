<?php

$wgEnableUploads = true;

wfLoadExtension( "Moderation" );

# Disable display_errors from DevelopmentSettings.php
# (interferes with ModerationTestsuiteCliEngine)
ini_set( 'display_errors', 0 );
