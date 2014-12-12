<?php

use Digital\Database;
require_once __DIR__ . '/../../src/bootstrap.php';

$db_settings = ["protocol" => "mysql","host" => "localhost","dbname" => "site","user" => "root","pass" => "root"];

$app = new \Silex\Application();
$app['debug'] = true;

$app->get('/', function (){
	return 'Welcome to the jungle';
});

$app->mount('/produto', include __DIR__ . '/../../src/Digital/Api/Controller/Produto.php');

$app->run();