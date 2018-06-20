<?php

$KEY = getenv( 'AWS_KEY' );
$SECRET = getenv( 'AWS_SECRET' );
$BUCKET_PREFIX = getenv( 'AWS_BUCKET_PREFIX' );
###############################################################################

require_once( "$IP/extensions/AWS/AWS.php" );

$wgAWSCredentials['key'] = $KEY;
$wgAWSCredentials['secret'] = $SECRET;

$wgAWSRegion = 'us-east-1'; # Northern Virginia

$wgFileBackends['s3']['containerPaths'] = [
	"$wgDBname-local-public" => "${BUCKET_PREFIX}-img",
	"$wgDBname-local-thumb" => "${BUCKET_PREFIX}-thumb",
	"$wgDBname-local-deleted" => "${BUCKET_PREFIX}-deleted",
	"$wgDBname-local-temp" => "${BUCKET_PREFIX}-temp"
];

$wgLocalFileRepo = array (
	'class'             => 'LocalRepo',
	'name'              => 'local',
	'backend'           => 'AmazonS3',
	'scriptDirUrl'      => $wgScriptPath,
	'url'               => $wgScriptPath . '/img_auth.php',
	'hashLevels'        => 0,
	'zones'             => [
		'public'  => [ 'url' => "http://${BUCKET_PREFIX}.s3.amazonaws.com" ],
		'thumb'   => [ 'url' => "http://${BUCKET_PREFIX}-thumb.s3.amazonaws.com" ],
		'temp'    => [ 'url' => false ],
		'deleted' => [ 'url' => false ]
	]
);
