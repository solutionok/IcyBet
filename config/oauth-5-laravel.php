<?php

use OAuth\Common\Storage\Session;

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => new Session(),

	/**
	 * Consumers
	 */
	'consumers' => [

		/**
		 * Facebook
		 */
		'Facebook' => [
		    'client_id'     => '',
		    'client_secret' => '',
		    'scope'         => [],
		],
        'Google' => [
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_SECRET_ID'),
            'scope'         => ['icybet.com', 'Kling Anton'],
        ],

	]

];
