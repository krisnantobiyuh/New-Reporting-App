<?php

return [
	//setting display error
	'displayErrorDetails'	=> true,

	'addContentLengthHeader' => false,

	//setting timezone
	'timezone'	=> 'Asia/Jakarta',

	//setting language
	'lang'	=> [
		'default'	=> 'idn',
	],

	//setting db (with doctrine)
	'db'	=> [
		'url'	=> 'mysql://root:root@localhost/report',
	],

	'determineRouteBeforeAppMiddleware' => true,

	//setting language
	'lang'	=> [
		'default'	=> 'en',
	],

	// Setting View
	'view' => [
		'path'	=>	__DIR__ . '/../views',
		'twig'	=> 	[
			'cache'	=>	false,
		]
	],

	'reporting' => [
	       'base_uri' => 'http://localhost/New-Reporting-App/public/api/',
	       'headers' => [
	           'key' 			=> $_ENV['REPORTING_API_KEY'],
	           'Accept' 		=> 'application/json',
	           'Content-Type' 	=> 'application/json',
	           'Authorization'  => @$_SESSION['key']['key_token']
	       ],
	  ],
];
