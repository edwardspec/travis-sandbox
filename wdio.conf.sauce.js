'use strict';

var merge = require( 'deepmerge' ),
	conf = require( './wdio.conf' ).config;

// Overwrite default settings
conf = merge( conf, {
	maxInstances: 5,

	services: [ 'sauce' ],
	user: process.env.SAUCE_USERNAME || '',
	key: process.env.SAUCE_ACCESS_KEY || '',
	sauceConnect: true,

	// Group all tests in SauceLabs Dashboard by the build ID
	build: process.env.TRAVIS_JOB_NUMBER,

	waitforTimeout: 40000,
	mochaOpts: {
		timeout: 180000
	}
} );

conf.capabilities = [
	/*
	{
		platform: 'Windows 10',
		browserName: 'MicrosoftEdge',
		version: '14.14393'
	},
	{
		platform: 'Windows 8.1',
		browserName: 'internet explorer',
		version: '11.0'
	},
	{
		platform: 'macOS 10.13',
		browserName: 'safari',
		version: '11.1',
		exclude: [
			// SafariDriver doesn't support sendKeys() to contenteditable,
			// so we can't test VisualEditor in it
			'specs/visualeditor.js'
		]
	},
	*/
	{ browserName: 'chrome', version: 'latest', extendedDebugging: true },
	{ browserName: 'firefox', version: 'latest', extendedDebugging: true }
];

conf.specs = [
	'specs/notify.js'
];

exports.config = conf;
