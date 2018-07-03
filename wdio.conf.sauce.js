'use strict';

var merge = require( 'deepmerge' ),
	wdioConf = require( './wdio.conf' );

// Overwrite default settings
exports.config = merge( wdioConf.config, {
	maxInstances: 1,

	capabilities: [
		{ browserName: 'chrome', version: 'latest' }
	],

	//services: [ 'sauce' ],
	user: process.env.SAUCE_USERNAME || '',
	key: process.env.SAUCE_ACCESS_KEY || '',
	//sauceConnect: true,

	waitforTimeout: 40000,
	mochaOpts: {
		timeout: 180000
	}
} );
