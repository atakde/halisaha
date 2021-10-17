<?php

$baseDir = str_replace("\\", "/", dirname(__DIR__));

return [
	'DB_TYPE' => '',
	'DB_HOST' => '',
	'DB_NAME' => '',
	'DB_USER' => '',
	'DB_PASS' => '',
	'DB_CHARSET' => '',
	'CONTROLLER_PATH' => $baseDir . '/controllers/',
	'VIEW_PATH' => $baseDir . '/views/',
	'MODEL_PATH' => $baseDir . '/models/',
	'URL_PUBLIC_FOLDER' => 'public',
	'URL_PROTOCOL' => '//',
	'URL_DOMAIN' => $_SERVER['HTTP_HOST'],
	'URL_SUB_FOLDER' => str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
	'URL' => '//' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME']))
];
