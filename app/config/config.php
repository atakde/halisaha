<?php

$baseDir = str_replace("\\", "/", dirname(__DIR__));

return [
	'DB_TYPE' => getenv('DB_TYPE'),
	'DB_HOST' => getenv('DB_HOST'),
	'DB_NAME' => getenv('DB_NAME'),
	'DB_USER' => getenv('DB_USER'),
	'DB_PASS' => getenv('DB_PASS'),
	'DB_PORT' => getenv('DB_PORT'),
	'DB_CHARSET' => '',
	'CONTROLLER_PATH' => $baseDir . '/controllers/',
	'VIEW_PATH' => $baseDir . '/views/',
	'MODEL_PATH' => $baseDir . '/models/',
	'LOG_PATH' => $baseDir . '/logs/',
	'URL_PUBLIC_FOLDER' => 'public',
	'URL_PROTOCOL' => '//',
	'URL_DOMAIN' => $_SERVER['HTTP_HOST'],
	'URL_SUB_FOLDER' => str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
	'URL' => '//' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME']))
];
