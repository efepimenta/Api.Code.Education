<?php

use Digital\Database;
require_once __DIR__ . '/../../src/bootstrap.php';

$app = new \Silex\Application();
$app['debug'] = true;

$app->get('/', function (){
	return 'Welcome to the jungle';
});

$app->mount('/produto', include __DIR__ . '/../../src/Digital/Api/Controller/Produto.php');

$app->run();